import { useEffect, useState } from 'react';
import { apiRequest, SCHOOL_ID } from '../../../api';
import {
  ClipboardList,
  Users,
  TrendingUp,
  CheckCircle2,
  SearchX,
  Loader2,
  AlertCircle,
  RefreshCw,
} from 'lucide-react';

function matchesPerformance(value, filter) {
  if (!filter) return true;
  if (value === null || value === undefined || value === '') return false;

  const score = Number(value);

  if (!Number.isFinite(score)) return false;
  if (filter === 'excellent') return score >= 90;
  if (filter === 'good') return score >= 75 && score < 90;
  if (filter === 'average') return score >= 60 && score < 75;
  if (filter === 'needs-improvement') return score < 60;
  return true;
}

function statusLabel(status) {
  switch (status) {
    case 'passed':
      return 'Passed';

    case 'failed':
      return 'Failed';

    case 'in-progress':
      return 'In Progress';

    case 'published':
      return 'Published';

    case 'draft':
      return 'Draft';

    case 'archived':
      return 'Archived';

    default:
      return status || 'Unknown';
  }
}

function statusClass(status) {
  switch (status) {
    case 'passed':
      return 'bg-emerald-500/10 text-emerald-400';

    case 'failed':
      return 'bg-red-500/10 text-red-400';

    case 'in-progress':
      return 'bg-amber-500/10 text-amber-400';

    case 'published':
      return 'bg-blue-500/10 text-blue-400';

    case 'draft':
      return 'bg-slate-500/10 text-slate-400';

    case 'archived':
      return 'bg-slate-500/10 text-slate-400';

    default:
      return 'bg-slate-500/10 text-slate-400';
  }
}

function TestReports({ filters = {} }) {
  const [tests, setTests] = useState([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  const fetchTestReports = async (signal) => {
    try {
      const response = await apiRequest(
        `/school/${SCHOOL_ID}/reports/tests`,
        { signal }
      );

      const result = await response.json();

      if (!response.ok) {
        throw new Error(
          result?.message ||
            `Request failed with status ${response.status}.`
        );
      }

      const records = Array.isArray(result?.data)
        ? result.data
        : Array.isArray(result?.data?.data)
          ? result.data.data
          : [];

      setTests(
        records.map((test) => ({
          ...test,
          title: test.title ?? test.name ?? test.test_title ?? 'Untitled test',
          className: test.className ?? test.class_name ?? test.class ?? '—',
          subject: test.subject ?? test.subject_name ?? '—',
          attempts: Number(test.attempts ?? test.total_attempts ?? 0),
          score: test.score ?? test.average_percentage ?? null,
          passRate: test.passRate ?? test.pass_rate ?? null,
          status: String(test.status ?? 'unknown').toLowerCase(),
        }))
      );
      setTotal(
        Number(result?.total ?? result?.data?.total ?? records.length)
      );
    } catch (fetchError) {
      if (fetchError?.name === 'AbortError') {
        return;
      }

      setTests([]);
      setTotal(0);
      setError(
        fetchError?.message || 'Unable to load test reports.'
      );
    } finally {
      if (!signal?.aborted) {
        setLoading(false);
      }
    }
  };

  const retryTestReports = () => {
    setLoading(true);
    setError('');
    fetchTestReports();
  };

  useEffect(() => {
    const controller = new AbortController();
    Promise.resolve().then(() => fetchTestReports(controller.signal));

    return () => controller.abort();
  }, []);

  const filteredTests = tests.filter((test) => {
    const search = (filters.search || '').toLowerCase().trim();

    const matchesSearch =
      !search ||
      [test.title, test.className, test.subject].some((value) =>
        String(value || '').toLowerCase().includes(search)
      );

    const matchesClass =
      !filters.selectedClass ||
      test.className === filters.selectedClass;

    const matchesSubject =
      !filters.selectedSubject ||
      String(test.subject || '').toLowerCase() ===
        String(filters.selectedSubject).toLowerCase();

    const matchesPerformanceFilter = matchesPerformance(
      test.score,
      filters.performance
    );

    const matchesStatus =
      !filters.status ||
      String(test.status || '').toLowerCase() ===
        String(filters.status).toLowerCase();

    return (
      matchesSearch &&
      matchesClass &&
      matchesSubject &&
      matchesPerformanceFilter &&
      matchesStatus
    );
  });

  const totalAttempts = filteredTests.reduce(
    (sum, test) => sum + test.attempts,
    0
  );

  const testsWithScores = filteredTests.filter(
    (test) => test.score !== null && Number.isFinite(Number(test.score))
  );
  const testsWithPassRates = filteredTests.filter(
    (test) => test.passRate !== null && Number.isFinite(Number(test.passRate))
  );
  const averageScore = testsWithScores.length
    ? testsWithScores.reduce((sum, test) => sum + Number(test.score), 0) /
      testsWithScores.length
    : null;
  const averagePassRate = testsWithPassRates.length
    ? testsWithPassRates.reduce((sum, test) => sum + Number(test.passRate), 0) /
      testsWithPassRates.length
    : null;

  if (loading) {
    return (
      <div className="flex min-h-[300px] items-center justify-center">
        <div className="flex items-center gap-3 text-slate-400">
          <Loader2 className="h-5 w-5 animate-spin" />
          <span>Loading test reports...</span>
        </div>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      {error ? (
        <div className="rounded-xl border border-red-500/20 bg-red-500/5 p-5">
          <div className="flex items-start gap-3">
            <AlertCircle className="mt-0.5 h-5 w-5 text-red-400" />
            <div className="flex-1">
              <h3 className="font-semibold text-red-300">
                Unable to load test reports
              </h3>
              <p className="mt-1 text-sm text-red-400/80">{error}</p>
              <button
                type="button"
                onClick={retryTestReports}
                className="mt-4 inline-flex items-center gap-2 rounded-lg border border-red-500/30 px-3 py-2 text-sm text-red-300 hover:bg-red-500/10"
              >
                <RefreshCw className="h-4 w-4" />
                Retry
              </button>
            </div>
          </div>
        </div>
      ) : null}

      <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <Card
          icon={ClipboardList}
          title="Tests"
          value={filteredTests.length}
        />

        <Card
          icon={Users}
          title="Total Attempts"
          value={totalAttempts}
        />

        <Card
          icon={TrendingUp}
          title="Average Score"
          value={averageScore !== null ? `${averageScore.toFixed(1)}%` : '—'}
        />

        <Card
          icon={CheckCircle2}
          title="Average Pass Rate"
          value={averagePassRate !== null ? `${averagePassRate.toFixed(1)}%` : '—'}
        />
      </div>

      <div className="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
        <div className="border-b border-slate-800 px-5 py-4">
          <h2 className="font-semibold text-white">
            Test Performance
          </h2>

          <p className="mt-1 text-sm text-slate-500">
            Showing {filteredTests.length} of {total} tests
          </p>
        </div>

        {filteredTests.length === 0 ? (
          <div className="flex flex-col items-center justify-center py-16 text-center">
            <SearchX className="h-10 w-10 text-slate-600" />

            <h3 className="mt-4 font-semibold text-white">
              No tests found
            </h3>

            <p className="mt-2 text-sm text-slate-500">
              Try changing your search or filters.
            </p>
          </div>
        ) : (
          <>
            <div className="hidden overflow-x-auto md:block">
              <table className="w-full text-left">
                <thead className="bg-slate-950/70 text-xs uppercase tracking-wide text-slate-500">
                  <tr>
                    <th className="px-5 py-4">Test</th>
                    <th className="px-5 py-4">Class</th>
                    <th className="px-5 py-4">Subject</th>
                    <th className="px-5 py-4">Attempts</th>
                    <th className="px-5 py-4">Score</th>
                    <th className="px-5 py-4">Pass Rate</th>
                    <th className="px-5 py-4">Status</th>
                  </tr>
                </thead>

                <tbody className="divide-y divide-slate-800">
                  {filteredTests.map((test) => (
                    <tr
                      key={test.id}
                      className="hover:bg-slate-800/40"
                    >
                      <td className="px-5 py-4 font-medium text-white">
                        {test.title}
                      </td>

                      <td className="px-5 py-4 text-sm text-slate-300">
                        {test.className}
                      </td>

                      <td className="px-5 py-4 text-sm text-slate-300">
                        {test.subject}
                      </td>

                      <td className="px-5 py-4 text-sm text-slate-300">
                        {test.attempts}
                      </td>

                      <td className="px-5 py-4 text-sm font-medium text-white">
                        {test.score === null ? 'No Data' : `${test.score}%`}
                      </td>

                      <td className="px-5 py-4 text-sm text-slate-300">
                        {test.passRate === null ? 'No Data' : `${test.passRate}%`}
                      </td>

                      <td className="px-5 py-4">
                        <span
                          className={`rounded-full px-2.5 py-1 text-xs font-medium ${statusClass(
                            test.status
                          )}`}
                        >
                          {statusLabel(test.status)}
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>

            <div className="divide-y divide-slate-800 md:hidden">
              {filteredTests.map((test) => (
                <div key={test.id} className="p-5">
                  <div className="flex items-start justify-between gap-3">
                    <div>
                      <h3 className="font-semibold text-white">
                        {test.title}
                      </h3>

                      <p className="mt-1 text-xs text-slate-500">
                        {test.className} · {test.subject}
                      </p>
                    </div>

                    <span
                      className={`rounded-full px-2.5 py-1 text-xs font-medium ${statusClass(
                        test.status
                      )}`}
                    >
                      {statusLabel(test.status)}
                    </span>
                  </div>

                  <div className="mt-4 grid grid-cols-2 gap-3">
                    <Info
                      label="Attempts"
                      value={test.attempts}
                    />

                    <Info
                      label="Score"
                      value={test.score === null ? 'No Data' : `${test.score}%`}
                    />

                    <Info
                      label="Pass Rate"
                      value={test.passRate === null ? 'No Data' : `${test.passRate}%`}
                    />
                  </div>
                </div>
              ))}
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
          <p className="mt-1 text-xl font-bold text-white">{value}</p>
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

export default TestReports;