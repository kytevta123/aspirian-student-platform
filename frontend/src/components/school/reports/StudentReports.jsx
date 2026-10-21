
import { useCallback, useEffect, useMemo, useRef, useState } from 'react';
import {
  Users,
  TrendingUp,
  ClipboardList,
  SearchX,
  Loader2,
  AlertCircle,
  RefreshCw,
  Mail,
  UserRound,
  CheckCircle2,
  XCircle,
  MinusCircle,
  BarChart3,
} from 'lucide-react';
import { apiRequest, SCHOOL_ID } from '../../../api';

const EMPTY_DASH = '—';

function toNumber(value) {
  if (value === null || value === undefined || value === '') {
    return null;
  }

  const number = Number(value);
  return Number.isFinite(number) ? number : null;
}

function formatNumber(value, decimals = 0) {
  const number = toNumber(value);

  return number === null ? EMPTY_DASH : number.toFixed(decimals);
}

function getPerformanceLabel(value) {
  const percentage = toNumber(value);

  if (percentage === null) {
    return {
      text: 'No Data',
      className: 'border-slate-700 bg-slate-800 text-slate-400',
      dotClassName: 'bg-slate-500',
    };
  }

  if (percentage >= 90) {
    return {
      text: 'Excellent',
      className:
        'border-emerald-500/20 bg-emerald-500/10 text-emerald-400',
      dotClassName: 'bg-emerald-400',
    };
  }

  if (percentage >= 75) {
    return {
      text: 'Good',
      className: 'border-blue-500/20 bg-blue-500/10 text-blue-400',
      dotClassName: 'bg-blue-400',
    };
  }

  if (percentage >= 60) {
    return {
      text: 'Average',
      className: 'border-amber-500/20 bg-amber-500/10 text-amber-400',
      dotClassName: 'bg-amber-400',
    };
  }

  return {
    text: 'Needs Improvement',
    className: 'border-red-500/20 bg-red-500/10 text-red-400',
    dotClassName: 'bg-red-400',
  };
}

function matchesPerformance(value, filter) {
  if (!filter || filter === 'all') {
    return true;
  }

  const percentage = toNumber(value);

  if (percentage === null) {
    return false;
  }

  switch (filter) {
    case 'excellent':
      return percentage >= 90;

    case 'good':
      return percentage >= 75 && percentage < 90;

    case 'average':
      return percentage >= 60 && percentage < 75;

    case 'needs-improvement':
      return percentage < 60;

    default:
      return true;
  }
}

function normalizeStatus(status) {
  return String(status ?? '').trim().toLowerCase();
}

function getStatusConfig(status) {
  const normalized = normalizeStatus(status);

  if (normalized === 'active') {
    return {
      label: 'Active',
      icon: CheckCircle2,
      className:
        'border-emerald-500/20 bg-emerald-500/10 text-emerald-400',
    };
  }

  if (normalized === 'inactive') {
    return {
      label: 'Inactive',
      icon: MinusCircle,
      className: 'border-slate-700 bg-slate-800 text-slate-400',
    };
  }

  if (normalized === 'suspended') {
    return {
      label: 'Suspended',
      icon: XCircle,
      className: 'border-red-500/20 bg-red-500/10 text-red-400',
    };
  }

  return {
    label: status
      ? String(status).charAt(0).toUpperCase() +
        String(status).slice(1)
      : 'Unknown',
    icon: MinusCircle,
    className: 'border-slate-700 bg-slate-800 text-slate-400',
  };
}

function StudentReports({ filters = {} }) {
  const [students, setStudents] = useState([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  const requestController = useRef(null);

  const fetchStudentReports = useCallback(async () => {
    requestController.current?.abort();

    const controller = new AbortController();
    requestController.current = controller;

    try {
      setLoading(true);
      setError('');

      const response = await apiRequest(
        `/school/${SCHOOL_ID}/reports/students`,
        { signal: controller.signal }
      );

      if (!response.ok) {
        let message = `Request failed with status ${response.status}.`;

        try {
          const errorData = await response.json();

          if (errorData?.message) {
            message = errorData.message;
          }
        } catch {
          // Use the default HTTP error message.
        }

        throw new Error(message);
      }

      const result = await response.json();

      if (controller.signal.aborted) {
        return;
      }

      // Support the standard API response and a nested data response.
      const records = Array.isArray(result?.data)
        ? result.data
        : Array.isArray(result?.data?.data)
          ? result.data.data
          : [];

      const responseTotal = toNumber(result?.total);

      setStudents(records);
      setTotal(
        responseTotal !== null && responseTotal >= 0
          ? responseTotal
          : records.length
      );
    } catch (err) {
      if (
        err?.name === 'AbortError' ||
        controller.signal.aborted
      ) {
        return;
      }

      console.error('Student reports error:', err);

      setStudents([]);
      setTotal(0);
      setError(
        err?.message ||
          'Unable to load student reports. Please try again.'
      );
    } finally {
      if (!controller.signal.aborted) {
        setLoading(false);
      }
    }
  }, []);

  useEffect(() => {
    fetchStudentReports();

    return () => {
      requestController.current?.abort();
    };
  }, [fetchStudentReports]);

  const filteredStudents = useMemo(() => {
    const search = String(filters.search ?? '')
      .toLowerCase()
      .trim();

    const performanceFilter = filters.performance ?? '';
    const statusFilter = normalizeStatus(filters.status);

    return students.filter((student) => {
      const name = String(student?.name ?? '').toLowerCase();
      const email = String(student?.email ?? '').toLowerCase();
      const studentId = String(
        student?.student_id ?? student?.id ?? ''
      ).toLowerCase();

      const matchesSearch =
        !search ||
        name.includes(search) ||
        email.includes(search) ||
        studentId.includes(search);

      const matchesScore = matchesPerformance(
        student?.average_percentage,
        performanceFilter
      );

      const matchesStatus =
        !statusFilter ||
        statusFilter === 'all' ||
        normalizeStatus(student?.status) === statusFilter;

      return matchesSearch && matchesScore && matchesStatus;
    });
  }, [
    students,
    filters.search,
    filters.performance,
    filters.status,
  ]);

  const summary = useMemo(() => {
    const validPercentages = filteredStudents
      .map((student) => toNumber(student?.average_percentage))
      .filter((value) => value !== null && value >= 0 && value <= 100);

    const averagePerformance =
      validPercentages.length > 0
        ? validPercentages.reduce((sum, value) => sum + value, 0) /
          validPercentages.length
        : null;

    const totalTests = filteredStudents.reduce((sum, student) => {
      const tests = toNumber(student?.total_tests);
      return sum + (tests !== null && tests > 0 ? tests : 0);
    }, 0);

    return {
      students: filteredStudents.length,
      averagePerformance,
      totalTests,
    };
  }, [filteredStudents]);

  return (
    <div className="space-y-6 text-slate-200">
      {/* Page introduction */}
      <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <div className="flex items-center gap-2 text-sm text-blue-400">
            <BarChart3 className="h-4 w-4" />
            <span>School Analytics</span>
          </div>

          <h1 className="mt-2 text-2xl font-bold tracking-tight text-white sm:text-3xl">
            Student Reports
          </h1>

          <p className="mt-2 max-w-2xl text-sm leading-6 text-slate-400">
            Monitor student performance, review test activity and
            track student status from one place.
          </p>
        </div>

        <button
          type="button"
          onClick={fetchStudentReports}
          disabled={loading}
          className="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-sm font-medium text-slate-200 transition hover:border-blue-500/50 hover:bg-slate-800 hover:text-white disabled:cursor-not-allowed disabled:opacity-50"
        >
          <RefreshCw
            className={`h-4 w-4 ${loading ? 'animate-spin' : ''}`}
          />
          Refresh Reports
        </button>
      </div>

      {/* Summary cards */}
      <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <SummaryCard
          icon={Users}
          title="Students"
          value={summary.students.toLocaleString()}
          description="Students matching current filters"
          iconClass="bg-blue-500/10 text-blue-400"
          accentClass="from-blue-500/20"
        />

        <SummaryCard
          icon={TrendingUp}
          title="Average Performance"
          value={
            summary.averagePerformance !== null
              ? `${summary.averagePerformance.toFixed(1)}%`
              : EMPTY_DASH
          }
          description="Average of available student scores"
          iconClass="bg-emerald-500/10 text-emerald-400"
          accentClass="from-emerald-500/20"
        />

        <SummaryCard
          icon={ClipboardList}
          title="Tests Attempted"
          value={summary.totalTests.toLocaleString()}
          description="Combined test count for displayed students"
          iconClass="bg-violet-500/10 text-violet-400"
          accentClass="from-violet-500/20"
        />
      </div>

      {/* Error state */}
      {error && (
        <div
          role="alert"
          className="rounded-2xl border border-red-500/20 bg-red-500/5 p-5"
        >
          <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div className="flex items-start gap-3">
              <div className="rounded-xl bg-red-500/10 p-2.5">
                <AlertCircle className="h-5 w-5 text-red-400" />
              </div>

              <div>
                <h3 className="font-semibold text-red-300">
                  Unable to load student reports
                </h3>

                <p className="mt-1 break-words text-sm leading-6 text-red-300/80">
                  {error}
                </p>
              </div>
            </div>

            <button
              type="button"
              onClick={fetchStudentReports}
              disabled={loading}
              className="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-2.5 text-sm font-medium text-red-300 transition hover:bg-red-500/20 disabled:opacity-50"
            >
              <RefreshCw
                className={`h-4 w-4 ${loading ? 'animate-spin' : ''}`}
              />
              Try Again
            </button>
          </div>
        </div>
      )}

      {/* Reports panel */}
      <section className="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/80 shadow-xl shadow-black/10">
        <div className="flex flex-col gap-3 border-b border-slate-800 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 className="text-lg font-semibold text-white">
              All Students
            </h2>

            <p className="mt-1 text-sm text-slate-400">
              Showing{' '}
              <span className="font-medium text-slate-200">
                {filteredStudents.length}
              </span>{' '}
              of{' '}
              <span className="font-medium text-slate-200">
                {total}
              </span>{' '}
              students returned by the API
            </p>
          </div>

          <div className="inline-flex w-fit items-center gap-2 rounded-lg border border-slate-800 bg-slate-950/70 px-3 py-2 text-xs text-slate-400">
            <span className="h-2 w-2 rounded-full bg-emerald-400" />
            Live API data
          </div>
        </div>

        {loading ? (
          <LoadingState />
        ) : filteredStudents.length === 0 ? (
          <EmptyState hasError={Boolean(error)} />
        ) : (
          <>
            {/* Desktop table */}
            <div className="hidden overflow-x-auto md:block">
              <table className="w-full min-w-[760px] text-left">
                <thead className="bg-slate-950/70">
                  <tr className="text-xs uppercase tracking-wider text-slate-500">
                    <th className="px-5 py-4 font-medium">Student</th>
                    <th className="px-5 py-4 font-medium">Email</th>
                    <th className="px-5 py-4 font-medium">
                      Performance
                    </th>
                    <th className="px-5 py-4 font-medium">Tests</th>
                    <th className="px-5 py-4 font-medium">Status</th>
                  </tr>
                </thead>

                <tbody className="divide-y divide-slate-800/80">
                  {filteredStudents.map((student, index) => (
                    <StudentTableRow
                      key={
                        student?.student_id ??
                        student?.id ??
                        `${student?.email ?? 'student'}-${index}`
                      }
                      student={student}
                    />
                  ))}
                </tbody>
              </table>
            </div>

            {/* Mobile cards */}
            <div className="divide-y divide-slate-800/80 md:hidden">
              {filteredStudents.map((student, index) => (
                <StudentMobileCard
                  key={
                    student?.student_id ??
                    student?.id ??
                    `${student?.email ?? 'student'}-${index}`
                  }
                  student={student}
                />
              ))}
            </div>
          </>
        )}

        {!loading && filteredStudents.length > 0 && (
          <div className="flex flex-col gap-2 border-t border-slate-800 bg-slate-950/40 px-5 py-3 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <span>
              {filteredStudents.length} student record
              {filteredStudents.length === 1 ? '' : 's'} displayed
            </span>

            <span>Performance categories are based on percentage.</span>
          </div>
        )}
      </section>
    </div>
  );
}

function SummaryCard({
  icon: Icon,
  title,
  value,
  description,
  iconClass,
  accentClass,
}) {
  return (
    <div className="relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 transition duration-200 hover:border-slate-700">
      <div
        className={`pointer-events-none absolute inset-x-0 top-0 h-24 bg-gradient-to-b ${accentClass} to-transparent opacity-60`}
      />

      <div className="relative flex items-start justify-between gap-3">
        <div>
          <p className="text-sm font-medium text-slate-400">
            {title}
          </p>

          <p className="mt-3 text-3xl font-bold tracking-tight text-white">
            {value}
          </p>
        </div>

        <div className={`rounded-xl p-3 ${iconClass}`}>
          <Icon className="h-5 w-5" />
        </div>
      </div>

      <p className="relative mt-4 text-xs leading-5 text-slate-500">
        {description}
      </p>
    </div>
  );
}

function StudentTableRow({ student }) {
  const performance = getPerformanceLabel(
    student?.average_percentage
  );

  return (
    <tr className="transition-colors hover:bg-slate-800/40">
      <td className="px-5 py-4">
        <div className="flex items-center gap-3">
          <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-blue-500/10 bg-blue-500/10">
            <UserRound className="h-5 w-5 text-blue-400" />
          </div>

          <div className="min-w-0">
            <p className="font-medium text-white">
              {student?.name || 'Unnamed Student'}
            </p>

            <p className="mt-1 text-xs text-slate-500">
              ID: {student?.student_id ?? student?.id ?? EMPTY_DASH}
            </p>
          </div>
        </div>
      </td>

      <td className="px-5 py-4">
        <div className="flex items-center gap-2 text-sm text-slate-300">
          <Mail className="h-4 w-4 shrink-0 text-slate-500" />
          <span className="max-w-[220px] truncate">
            {student?.email || EMPTY_DASH}
          </span>
        </div>
      </td>

      <td className="px-5 py-4">
        <div className="flex flex-col items-start gap-2">
          <span
            className={`inline-flex items-center gap-2 rounded-full border px-2.5 py-1 text-xs font-medium ${performance.className}`}
          >
            <span
              className={`h-1.5 w-1.5 rounded-full ${performance.dotClassName}`}
            />
            {toNumber(student?.average_percentage) !== null
              ? `${formatNumber(student.average_percentage, 1)}%`
              : performance.text}
          </span>

          {toNumber(student?.average_percentage) !== null && (
            <div className="h-1.5 w-24 overflow-hidden rounded-full bg-slate-800">
              <div
                className={`h-full rounded-full ${
                  toNumber(student.average_percentage) >= 75
                    ? 'bg-emerald-400'
                    : toNumber(student.average_percentage) >= 60
                      ? 'bg-amber-400'
                      : 'bg-red-400'
                }`}
                style={{
                  width: `${Math.min(
                    100,
                    Math.max(0, toNumber(student.average_percentage))
                  )}%`,
                }}
              />
            </div>
          )}
        </div>
      </td>

      <td className="px-5 py-4">
        <span className="inline-flex min-w-10 items-center justify-center rounded-lg border border-slate-700 bg-slate-950 px-2.5 py-1.5 text-sm font-medium text-slate-200">
          {student?.total_tests ?? 0}
        </span>
      </td>

      <td className="px-5 py-4">
        <StatusBadge status={student?.status} />
      </td>
    </tr>
  );
}

function StudentMobileCard({ student }) {
  const performance = getPerformanceLabel(
    student?.average_percentage
  );

  return (
    <article className="p-5 transition-colors hover:bg-slate-800/20">
      <div className="flex items-start gap-3">
        <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-blue-500/10 bg-blue-500/10">
          <UserRound className="h-5 w-5 text-blue-400" />
        </div>

        <div className="min-w-0 flex-1">
          <h3 className="break-words font-semibold text-white">
            {student?.name || 'Unnamed Student'}
          </h3>

          <p className="mt-1 break-all text-xs text-slate-400">
            {student?.email || EMPTY_DASH}
          </p>

          <p className="mt-1 text-xs text-slate-500">
            Student ID: {student?.student_id ?? student?.id ?? EMPTY_DASH}
          </p>
        </div>

        <span
          className={`shrink-0 rounded-full border px-2 py-1 text-xs font-medium ${performance.className}`}
        >
          {toNumber(student?.average_percentage) !== null
            ? `${formatNumber(student.average_percentage, 1)}%`
            : EMPTY_DASH}
        </span>
      </div>

      <div className="mt-4 grid grid-cols-2 gap-3">
        <div className="rounded-xl border border-slate-800 bg-slate-950/70 p-3">
          <div className="flex items-center gap-2 text-xs text-slate-500">
            <ClipboardList className="h-3.5 w-3.5" />
            Tests Attempted
          </div>

          <p className="mt-2 text-lg font-semibold text-white">
            {student?.total_tests ?? 0}
          </p>
        </div>

        <div className="rounded-xl border border-slate-800 bg-slate-950/70 p-3">
          <p className="text-xs text-slate-500">Account Status</p>

          <div className="mt-2">
            <StatusBadge status={student?.status} />
          </div>
        </div>
      </div>
    </article>
  );
}

function StatusBadge({ status }) {
  const config = getStatusConfig(status);
  const Icon = config.icon;

  return (
    <span
      className={`inline-flex items-center gap-1.5 whitespace-nowrap rounded-full border px-2.5 py-1 text-xs font-medium ${config.className}`}
    >
      <Icon className="h-3.5 w-3.5" />
      {config.label}
    </span>
  );
}

function LoadingState() {
  return (
    <div
      className="space-y-4 p-5 sm:p-6"
      role="status"
      aria-live="polite"
    >
      <div className="flex items-center gap-3 text-sm text-blue-400">
        <Loader2 className="h-5 w-5 animate-spin" />
        Loading student reports...
      </div>

      {[1, 2, 3, 4].map((item) => (
        <div
          key={item}
          className="flex animate-pulse items-center gap-4 rounded-xl border border-slate-800 bg-slate-950/50 p-4"
        >
          <div className="h-10 w-10 shrink-0 rounded-xl bg-slate-800" />

          <div className="flex-1 space-y-2">
            <div className="h-3 w-36 max-w-full rounded bg-slate-800" />
            <div className="h-2.5 w-48 max-w-full rounded bg-slate-800/70" />
          </div>

          <div className="hidden h-6 w-20 rounded-full bg-slate-800 sm:block" />
        </div>
      ))}

      <p className="text-center text-xs text-slate-500">
        Please wait while the latest student data is loaded.
      </p>
    </div>
  );
}

function EmptyState({ hasError = false }) {
  return (
    <div className="flex min-h-72 flex-col items-center justify-center px-6 py-14 text-center">
      <div className="rounded-2xl border border-slate-800 bg-slate-950 p-4">
        {hasError ? (
          <AlertCircle className="h-8 w-8 text-red-400" />
        ) : (
          <SearchX className="h-8 w-8 text-slate-500" />
        )}
      </div>

      <h3 className="mt-5 text-lg font-semibold text-white">
        {hasError ? 'Student reports unavailable' : 'No students found'}
      </h3>

      <p className="mt-2 max-w-md text-sm leading-6 text-slate-400">
        {hasError
          ? 'The reports could not be loaded. Check the API connection and try refreshing.'
          : 'No student records match the current search or performance filters. Try adjusting the filters.'}
      </p>
    </div>
  );
}

export default StudentReports;