import { useEffect, useMemo, useState } from 'react';
import {
  BookOpen,
  ClipboardList,
  TrendingUp,
  SearchX,
  Loader2,
  AlertCircle,
  RefreshCw,
} from 'lucide-react';
import { apiRequest, SCHOOL_ID } from '../../../api';

function matchesPerformance(value, filter) {
  if (!filter) return true;

  if (value === null || value === undefined) {
    return false;
  }

  if (filter === 'excellent') return value >= 90;
  if (filter === 'good') return value >= 75 && value < 90;
  if (filter === 'average') return value >= 60 && value < 75;
  if (filter === 'needs-improvement') return value < 60;

  return true;
}

function getPerformance(value) {
  if (value === null || value === undefined) {
    return 'bg-slate-500/10 text-slate-400';
  }

  if (value >= 90) {
    return 'bg-emerald-500/10 text-emerald-400';
  }

  if (value >= 75) {
    return 'bg-blue-500/10 text-blue-400';
  }

  if (value >= 60) {
    return 'bg-amber-500/10 text-amber-400';
  }

  return 'bg-red-500/10 text-red-400';
}

function getPerformanceText(value) {
  if (value === null || value === undefined) {
    return 'No Data';
  }

  return `${Number(value).toFixed(1)}%`;
}

function SubjectReports({ filters = {} }) {
  const [subjects, setSubjects] = useState([]);
  const [total, setTotal] = useState(0);

  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  const fetchSubjectReports = async () => {
    try {
      setLoading(true);
      setError('');

      const response = await apiRequest(
        `/school/${SCHOOL_ID}/reports/subjects`
      );

      if (!response.ok) {
        let message = `Request failed with status ${response.status}.`;

        try {
          const errorData = await response.json();

          if (errorData?.message) {
            message = errorData.message;
          }
        } catch {
          // Keep the default error message.
        }

        throw new Error(message);
      }

      const result = await response.json();

      setSubjects(
        Array.isArray(result?.data)
          ? result.data
          : []
      );

      setTotal(
        typeof result?.total === 'number'
          ? result.total
          : Array.isArray(result?.data)
            ? result.data.length
            : 0
      );
    } catch (err) {
      console.error('Subject reports error:', err);

      setSubjects([]);
      setTotal(0);

      setError(
        err?.message ||
          'Unable to load subject reports. Please try again.'
      );
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchSubjectReports();
  }, []);

  const filteredSubjects = useMemo(() => {
    return subjects.filter((subject) => {
      const search = (filters.search || '')
        .toLowerCase()
        .trim();

      const name = String(
        subject?.name || ''
      ).toLowerCase();

      const matchesSearch =
        !search || name.includes(search);

      const matchesSubject =
        !filters.selectedSubject ||
        String(subject?.name || '') ===
          String(filters.selectedSubject);

      const performance =
        subject?.average_percentage ?? null;

      const matchesPerformanceFilter =
        matchesPerformance(
          performance,
          filters.performance
        );

      return (
        matchesSearch &&
        matchesSubject &&
        matchesPerformanceFilter
      );
    });
  }, [
    subjects,
    filters.search,
    filters.selectedSubject,
    filters.performance,
  ]);

  const totalTests = filteredSubjects.reduce(
    (sum, subject) =>
      sum + Number(subject?.total_tests || 0),
    0
  );

  const totalResults = filteredSubjects.reduce(
    (sum, subject) =>
      sum + Number(subject?.total_results || 0),
    0
  );

  const subjectsWithPerformance =
    filteredSubjects.filter(
      (subject) =>
        subject?.average_percentage !== null &&
        subject?.average_percentage !== undefined
    );

  const averagePerformance =
    subjectsWithPerformance.length > 0
      ? subjectsWithPerformance.reduce(
          (sum, subject) =>
            sum +
            Number(
              subject?.average_percentage || 0
            ),
          0
        ) / subjectsWithPerformance.length
      : 0;

  return (
    <div className="space-y-6">
      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <Card
          icon={BookOpen}
          title="Subjects"
          value={filteredSubjects.length}
        />

        <Card
          icon={ClipboardList}
          title="Tests"
          value={totalTests}
        />

        <Card
          icon={TrendingUp}
          title="Test Results"
          value={totalResults}
        />

        <Card
          icon={TrendingUp}
          title="Avg Performance"
          value={
            subjectsWithPerformance.length > 0
              ? `${averagePerformance.toFixed(1)}%`
              : '—'
          }
        />
      </div>

      {error ? (
        <div className="rounded-2xl border border-red-500/20 bg-red-500/5 p-5">
          <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div className="flex items-start gap-3">
              <div className="rounded-lg bg-red-500/10 p-2">
                <AlertCircle className="h-5 w-5 text-red-400" />
              </div>

              <div>
                <h3 className="font-semibold text-red-300">
                  Unable to load subject reports
                </h3>

                <p className="mt-1 text-sm text-red-400/80">
                  {error}
                </p>
              </div>
            </div>

            <button
              type="button"
              onClick={fetchSubjectReports}
              className="inline-flex items-center justify-center gap-2 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-2 text-sm font-medium text-red-300 transition hover:bg-red-500/20"
            >
              <RefreshCw className="h-4 w-4" />
              Retry
            </button>
          </div>
        </div>
      ) : null}

      <div className="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
        <div className="flex flex-col gap-3 border-b border-slate-800 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 className="font-semibold text-white">
              Subject Performance
            </h2>

            <p className="mt-1 text-sm text-slate-500">
              Showing {filteredSubjects.length} of {total} subjects
            </p>
          </div>

          <button
            type="button"
            onClick={fetchSubjectReports}
            disabled={loading}
            className="inline-flex w-fit items-center gap-2 rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-300 transition hover:border-slate-600 hover:text-white disabled:cursor-not-allowed disabled:opacity-50"
          >
            <RefreshCw
              className={`h-4 w-4 ${
                loading ? 'animate-spin' : ''
              }`}
            />
            Refresh
          </button>
        </div>

        {loading ? (
          <LoadingState />
        ) : filteredSubjects.length === 0 ? (
          <EmptyState />
        ) : (
          <>
            <div className="hidden overflow-x-auto md:block">
              <table className="w-full text-left">
                <thead className="bg-slate-950/70 text-xs uppercase tracking-wide text-slate-500">
                  <tr>
                    <th className="px-5 py-4">
                      Subject
                    </th>

                    <th className="px-5 py-4">
                      Questions
                    </th>

                    <th className="px-5 py-4">
                      Tests
                    </th>

                    <th className="px-5 py-4">
                      Results
                    </th>

                    <th className="px-5 py-4">
                      Performance
                    </th>
                  </tr>
                </thead>

                <tbody className="divide-y divide-slate-800">
                  {filteredSubjects.map((subject) => {
                    const performance =
                      subject?.average_percentage;

                    return (
                      <tr
                        key={subject?.subject_id}
                        className="transition hover:bg-slate-800/40"
                      >
                        <td className="px-5 py-4 font-medium text-white">
                          {subject?.name || '—'}
                        </td>

                        <td className="px-5 py-4 text-sm text-slate-300">
                          {subject?.total_questions ?? 0}
                        </td>

                        <td className="px-5 py-4 text-sm text-slate-300">
                          {subject?.total_tests ?? 0}
                        </td>

                        <td className="px-5 py-4 text-sm text-slate-300">
                          {subject?.total_results ?? 0}
                        </td>

                        <td className="px-5 py-4">
                          <span
                            className={`rounded-full px-2.5 py-1 text-xs font-medium ${getPerformance(
                              performance
                            )}`}
                          >
                            {getPerformanceText(
                              performance
                            )}
                          </span>
                        </td>
                      </tr>
                    );
                  })}
                </tbody>
              </table>
            </div>

            <div className="divide-y divide-slate-800 md:hidden">
              {filteredSubjects.map((subject) => {
                const performance =
                  subject?.average_percentage;

                return (
                  <div
                    key={subject?.subject_id}
                    className="p-5"
                  >
                    <div className="flex items-center justify-between gap-3">
                      <h3 className="font-semibold text-white">
                        {subject?.name || '—'}
                      </h3>

                      <span
                        className={`shrink-0 rounded-full px-2.5 py-1 text-xs font-medium ${getPerformance(
                          performance
                        )}`}
                      >
                        {getPerformanceText(
                          performance
                        )}
                      </span>
                    </div>

                    <div className="mt-4 grid grid-cols-2 gap-3">
                      <Info
                        label="Questions"
                        value={
                          subject?.total_questions ?? 0
                        }
                      />

                      <Info
                        label="Tests"
                        value={
                          subject?.total_tests ?? 0
                        }
                      />

                      <Info
                        label="Results"
                        value={
                          subject?.total_results ?? 0
                        }
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
          <p className="text-xs text-slate-500">
            {title}
          </p>

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
      <p className="text-xs text-slate-500">
        {label}
      </p>

      <p className="mt-1 text-sm text-slate-200">
        {value}
      </p>
    </div>
  );
}

function LoadingState() {
  return (
    <div className="flex min-h-72 flex-col items-center justify-center px-6 py-16 text-center">
      <Loader2 className="h-9 w-9 animate-spin text-blue-400" />

      <h3 className="mt-4 font-semibold text-white">
        Loading subject reports
      </h3>

      <p className="mt-2 text-sm text-slate-500">
        Please wait while the latest subject data is loaded.
      </p>
    </div>
  );
}

function EmptyState() {
  return (
    <div className="flex min-h-72 flex-col items-center justify-center px-6 py-16 text-center">
      <SearchX className="h-10 w-10 text-slate-600" />

      <h3 className="mt-4 font-semibold text-white">
        No subjects found
      </h3>

      <p className="mt-2 max-w-md text-sm text-slate-500">
        No subject records match the current search or performance filters.
      </p>
    </div>
  );
}

export default SubjectReports;