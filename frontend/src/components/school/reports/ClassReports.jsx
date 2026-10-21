import { useEffect, useState } from 'react';
import {
  GraduationCap,
  Users,
  TrendingUp,
  ClipboardCheck,
  SearchX,
  RefreshCw,
  Loader2,
} from 'lucide-react';
import { apiRequest, SCHOOL_ID } from '../../../api';

function getPerformanceLabel(value) {
  if (value === null || value === undefined) {
    return {
      text: 'No Data',
      className: 'bg-slate-500/10 text-slate-400',
    };
  }

  if (value >= 90) {
    return {
      text: 'Excellent',
      className: 'bg-emerald-500/10 text-emerald-400',
    };
  }

  if (value >= 75) {
    return {
      text: 'Good',
      className: 'bg-blue-500/10 text-blue-400',
    };
  }

  if (value >= 60) {
    return {
      text: 'Average',
      className: 'bg-amber-500/10 text-amber-400',
    };
  }

  return {
    text: 'Needs Improvement',
    className: 'bg-red-500/10 text-red-400',
  };
}

function matchesPerformance(value, filter) {
  if (!filter) return true;

  // Backend null means there is currently no performance data.
  if (value === null || value === undefined) {
    return false;
  }

  if (filter === 'excellent') return value >= 90;
  if (filter === 'good') return value >= 75 && value < 90;
  if (filter === 'average') return value >= 60 && value < 75;
  if (filter === 'needs-improvement') return value < 60;

  return true;
}

function ClassReports({ filters = {} }) {
  const [classes, setClasses] = useState([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  const fetchClassReports = async () => {
    try {
      setLoading(true);
      setError('');

      const response = await apiRequest(
        `/school/${SCHOOL_ID}/reports/classes`
      );

      const result = await response.json();

      if (!response.ok) {
        throw new Error(
          result?.message || 'Unable to load class reports.'
        );
      }

      setClasses(Array.isArray(result?.data) ? result.data : []);
      setTotal(Number(result?.total || 0));
    } catch (err) {
      console.error('Class reports error:', err);
      setError(
        err?.message || 'Unable to load class reports.'
      );
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchClassReports();
  }, []);

  const filteredClasses = classes.filter((item) => {
    const search = (filters.search || '').toLowerCase().trim();

    const className = String(item.name || '').toLowerCase();

    const matchesSearch =
      !search || className.includes(search);

    const matchesClass =
      !filters.selectedClass ||
      item.name === filters.selectedClass;

    const matchesPerformanceFilter = matchesPerformance(
      item.average_percentage,
      filters.performance
    );

    return (
      matchesSearch &&
      matchesClass &&
      matchesPerformanceFilter
    );
  });

  const totalStudents = filteredClasses.reduce(
    (sum, item) => sum + Number(item.total_students || 0),
    0
  );

  const performanceValues = filteredClasses
    .map((item) => item.average_percentage)
    .filter(
      (value) =>
        value !== null &&
        value !== undefined &&
        !Number.isNaN(Number(value))
    )
    .map(Number);

  const averagePerformance =
    performanceValues.length > 0
      ? performanceValues.reduce(
          (sum, value) => sum + value,
          0
        ) / performanceValues.length
      : null;

  const totalTestsTaken = filteredClasses.reduce(
    (sum, item) => sum + Number(item.total_tests_taken || 0),
    0
  );

  if (loading) {
    return (
      <div className="flex min-h-[300px] items-center justify-center">
        <div className="flex items-center gap-3 text-slate-400">
          <Loader2 className="h-5 w-5 animate-spin" />
          <span>Loading class reports...</span>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="rounded-2xl border border-red-500/20 bg-red-500/5 p-8 text-center">
        <SearchX className="mx-auto h-10 w-10 text-red-400" />

        <h3 className="mt-4 font-semibold text-white">
          Unable to load class reports
        </h3>

        <p className="mx-auto mt-2 max-w-lg text-sm text-red-300">
          {error}
        </p>

        <button
          type="button"
          onClick={fetchClassReports}
          className="mt-5 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-500"
        >
          <RefreshCw className="h-4 w-4" />
          Retry
        </button>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <Card
          icon={GraduationCap}
          title="Total Classes"
          value={filteredClasses.length}
        />

        <Card
          icon={Users}
          title="Total Students"
          value={totalStudents}
        />

        <Card
          icon={TrendingUp}
          title="Avg Performance"
          value={
            averagePerformance !== null
              ? `${averagePerformance.toFixed(1)}%`
              : 'No Data'
          }
        />

        <Card
          icon={ClipboardCheck}
          title="Tests Taken"
          value={totalTestsTaken}
        />
      </div>

      <div className="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
        <div className="border-b border-slate-800 px-5 py-4">
          <div className="flex items-center justify-between gap-4">
            <div>
              <h2 className="font-semibold text-white">
                Class Performance
              </h2>

              <p className="mt-1 text-xs text-slate-500">
                {filteredClasses.length} of {total} classes
              </p>
            </div>

            <button
              type="button"
              onClick={fetchClassReports}
              className="inline-flex items-center gap-2 rounded-lg border border-slate-700 px-3 py-2 text-xs font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
              <RefreshCw className="h-4 w-4" />
              Refresh
            </button>
          </div>
        </div>

        {filteredClasses.length === 0 ? (
          <div className="flex flex-col items-center justify-center py-16 text-center">
            <SearchX className="h-10 w-10 text-slate-600" />

            <h3 className="mt-4 font-semibold text-white">
              No classes found
            </h3>

            <p className="mt-2 text-sm text-slate-500">
              Try changing your search or report filters.
            </p>
          </div>
        ) : (
          <>
            <div className="hidden overflow-x-auto md:block">
              <table className="w-full text-left">
                <thead className="bg-slate-950/70 text-xs uppercase tracking-wide text-slate-500">
                  <tr>
                    <th className="px-5 py-4">Class</th>
                    <th className="px-5 py-4">Students</th>
                    <th className="px-5 py-4">Tests Taken</th>
                    <th className="px-5 py-4">Performance</th>
                  </tr>
                </thead>

                <tbody className="divide-y divide-slate-800">
                  {filteredClasses.map((item) => {
                    const performanceValue =
                      item.average_percentage !== null &&
                      item.average_percentage !== undefined
                        ? Number(item.average_percentage)
                        : null;

                    const performance =
                      getPerformanceLabel(performanceValue);

                    return (
                      <tr
                        key={item.id ?? item.class_id}
                        className="hover:bg-slate-800/40"
                      >
                        <td className="px-5 py-4 font-medium text-white">
                          {item.name}
                        </td>

                        <td className="px-5 py-4 text-sm text-slate-300">
                          {Number(item.total_students || 0)}
                        </td>

                        <td className="px-5 py-4 text-sm text-slate-300">
                          {Number(item.total_tests_taken || 0)}
                        </td>

                        <td className="px-5 py-4">
                          <span
                            className={`rounded-full px-2.5 py-1 text-xs font-medium ${performance.className}`}
                          >
                            {performanceValue !== null
                              ? `${performanceValue.toFixed(1)}% · `
                              : ''}
                            {performance.text}
                          </span>
                        </td>
                      </tr>
                    );
                  })}
                </tbody>
              </table>
            </div>

            <div className="divide-y divide-slate-800 md:hidden">
              {filteredClasses.map((item) => {
                const performanceValue =
                  item.average_percentage !== null &&
                  item.average_percentage !== undefined
                    ? Number(item.average_percentage)
                    : null;

                const performance =
                  getPerformanceLabel(performanceValue);

                return (
                  <div
                    key={item.id ?? item.class_id}
                    className="p-5"
                  >
                    <div className="flex items-center justify-between gap-4">
                      <h3 className="font-semibold text-white">
                        {item.name}
                      </h3>

                      <span
                        className={`rounded-full px-2.5 py-1 text-xs font-medium ${performance.className}`}
                      >
                        {performanceValue !== null
                          ? `${performanceValue.toFixed(1)}%`
                          : 'No Data'}
                      </span>
                    </div>

                    <div className="mt-4 grid grid-cols-2 gap-3">
                      <Info
                        label="Students"
                        value={Number(
                          item.total_students || 0
                        )}
                      />

                      <Info
                        label="Tests Taken"
                        value={Number(
                          item.total_tests_taken || 0
                        )}
                      />
                    </div>
                  </div>
                );
              })}
            </div>
          </>
        )}
      </div>
    </div>
  );
}

function Card({ icon: Icon, title, value }) {
  return (
    <div className="rounded-2xl border border-slate-800 bg-slate-900 p-5">
      <div className="flex items-center gap-3">
        <div className="rounded-xl bg-blue-500/10 p-2.5">
          <Icon className="h-5 w-5 text-blue-400" />
        </div>

        <div>
          <p className="text-xs text-slate-500">{title}</p>
          <p className="mt-1 text-xl font-bold text-white">
            {value}
          </p>
        </div>
      </div>
    </div>
  );
}

function Info({ label, value }) {
  return (
    <div className="rounded-lg bg-slate-950 p-3">
      <p className="text-xs text-slate-500">{label}</p>
      <p className="mt-1 text-sm text-slate-200">{value}</p>
    </div>
  );
}

export default ClassReports;