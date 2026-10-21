import { Search, X, Filter } from 'lucide-react';

const subjects = [
  'English',
  'Urdu',
  'Mathematics',
  'Physics',
  'Chemistry',
  'Biology',
  'Computer Science',
  'General Science',
  'Islamiat',
  'Pakistan Studies',
];

function ReportFilters({
  reportType,
  search,
  selectedSubject,
  performance,
  status,
  onSearchChange,
  onSubjectChange,
  onPerformanceChange,
  onStatusChange,
  onClear,
}) {
  const hasFilters =
    search ||
    selectedSubject ||
    performance ||
    status;

  const getSearchPlaceholder = () => {
    switch (reportType) {
      case 'students':
        return 'Search student name or email...';

      case 'classes':
        return 'Search class...';

      case 'subjects':
        return 'Search subject...';

      case 'tests':
        return 'Search test...';

      default:
        return 'Search reports...';
    }
  };

  const showSubjectFilter =
    reportType === 'subjects';

  const showStatusFilter =
    reportType === 'tests';

  return (
    <div className="mb-6 rounded-2xl border border-white/10 bg-slate-900/70 p-4 shadow-lg">
      <div className="mb-4 flex items-center justify-between">
        <div className="flex items-center gap-2">
          <Filter className="h-5 w-5 text-cyan-400" />

          <h3 className="text-sm font-semibold text-white">
            Report Filters
          </h3>
        </div>

        {hasFilters && (
          <button
            type="button"
            onClick={onClear}
            className="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-xs font-medium text-slate-300 transition hover:bg-white/10 hover:text-white"
          >
            <X className="h-4 w-4" />
            Clear Filters
          </button>
        )}
      </div>

      <div
        className={`grid grid-cols-1 gap-4 md:grid-cols-2 ${
          showSubjectFilter || showStatusFilter
            ? 'lg:grid-cols-4'
            : 'lg:grid-cols-3'
        }`}
      >
        {/* Search */}
        <div className="lg:col-span-2">
          <label className="mb-2 block text-xs font-medium text-slate-400">
            Search
          </label>

          <div className="relative">
            <Search className="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" />

            <input
              type="text"
              value={search}
              onChange={(e) =>
                onSearchChange(e.target.value)
              }
              placeholder={getSearchPlaceholder()}
              className="w-full rounded-xl border border-white/10 bg-slate-950/70 py-2.5 pl-10 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/50"
            />
          </div>
        </div>

        {/* Subject */}
        {showSubjectFilter && (
          <div>
            <label className="mb-2 block text-xs font-medium text-slate-400">
              Subject
            </label>

            <select
              value={selectedSubject}
              onChange={(e) =>
                onSubjectChange(e.target.value)
              }
              className="w-full rounded-xl border border-white/10 bg-slate-950/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-500/50"
            >
              <option value="">All Subjects</option>

              {subjects.map((subject) => (
                <option key={subject} value={subject}>
                  {subject}
                </option>
              ))}
            </select>
          </div>
        )}

        {/* Performance */}
        <div>
          <label className="mb-2 block text-xs font-medium text-slate-400">
            Performance
          </label>

          <select
            value={performance}
            onChange={(e) =>
              onPerformanceChange(e.target.value)
            }
            className="w-full rounded-xl border border-white/10 bg-slate-950/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-500/50"
          >
            <option value="">All Performance</option>
            <option value="excellent">
              Excellent (90%+)
            </option>
            <option value="good">
              Good (75–89%)
            </option>
            <option value="average">
              Average (60–74%)
            </option>
            <option value="needs-improvement">
              Needs Improvement (&lt;60%)
            </option>
          </select>
        </div>

        {/* Test Status */}
        {showStatusFilter && (
          <div>
            <label className="mb-2 block text-xs font-medium text-slate-400">
              Status
            </label>

            <select
              value={status}
              onChange={(e) =>
                onStatusChange(e.target.value)
              }
              className="w-full rounded-xl border border-white/10 bg-slate-950/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-500/50"
            >
              <option value="">All Status</option>
              <option value="completed">
                Completed
              </option>
              <option value="published">
                Published
              </option>
              <option value="draft">
                Draft
              </option>
              <option value="active">
                Active
              </option>
            </select>
          </div>
        )}
      </div>
    </div>
  );
}

export default ReportFilters;