import { useState } from 'react';
import {
  Users,
  GraduationCap,
  BookOpen,
  ClipboardList,
  BarChart3,
  ArrowLeft,
} from 'lucide-react';

import ReportFilters from '../components/school/reports/ReportFilters';
import StudentReports from '../components/school/reports/StudentReports';
import ClassReports from '../components/school/reports/ClassReports';
import SubjectReports from '../components/school/reports/SubjectReports';
import TestReports from '../components/school/reports/TestReports';

const reportTypes = [
  {
    id: 'students',
    title: 'Student Reports',
    description: 'View student performance and test activity.',
    icon: Users,
  },
  {
    id: 'classes',
    title: 'Class Reports',
    description:
      'Analyze class-wise student performance and test activity.',
    icon: GraduationCap,
  },
  {
    id: 'subjects',
    title: 'Subject Reports',
    description:
      'Compare subject performance and test results.',
    icon: BookOpen,
  },
  {
    id: 'tests',
    title: 'Test Reports',
    description:
      'Review tests, attempts, scores and pass rates.',
    icon: ClipboardList,
  },
];

function SchoolReports() {
  const [selectedReport, setSelectedReport] = useState(null);

  const [filters, setFilters] = useState({
    search: '',
    selectedSubject: '',
    performance: '',
    status: '',
  });

  const handleReportSelect = (report) => {
    setSelectedReport(report);

    setFilters({
      search: '',
      selectedSubject: '',
      performance: '',
      status: '',
    });
  };

  const handleSearchChange = (value) => {
    setFilters((prev) => ({
      ...prev,
      search: value,
    }));
  };

  const handleSubjectChange = (value) => {
    setFilters((prev) => ({
      ...prev,
      selectedSubject: value,
    }));
  };

  const handlePerformanceChange = (value) => {
    setFilters((prev) => ({
      ...prev,
      performance: value,
    }));
  };

  const handleStatusChange = (value) => {
    setFilters((prev) => ({
      ...prev,
      status: value,
    }));
  };

  const clearFilters = () => {
    setFilters({
      search: '',
      selectedSubject: '',
      performance: '',
      status: '',
    });
  };

  const renderSelectedReport = () => {
    if (!selectedReport) {
      return null;
    }

    switch (selectedReport.id) {
      case 'students':
        return <StudentReports filters={filters} />;

      case 'classes':
        return <ClassReports filters={filters} />;

      case 'subjects':
        return <SubjectReports filters={filters} />;

      case 'tests':
        return <TestReports filters={filters} />;

      default:
        return null;
    }
  };

  return (
    <div className="min-h-screen bg-slate-950 text-white">
      <div className="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {!selectedReport ? (
          <>
            <div className="mb-8">
              <div className="mb-3 flex items-center gap-3">
                <div className="rounded-xl bg-blue-500/10 p-3">
                  <BarChart3 className="h-7 w-7 text-blue-400" />
                </div>

                <div>
                  <h1 className="text-2xl font-bold sm:text-3xl">
                    School Reports
                  </h1>

                  <p className="mt-1 text-sm text-slate-400">
                    Analyze students, classes, subjects and tests.
                  </p>
                </div>
              </div>
            </div>

            <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
              {reportTypes.map((report) => {
                const Icon = report.icon;

                return (
                  <button
                    key={report.id}
                    type="button"
                    onClick={() => handleReportSelect(report)}
                    className="group rounded-2xl border border-slate-800 bg-slate-900 p-6 text-left transition hover:border-blue-500/50 hover:bg-slate-800"
                  >
                    <div className="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10">
                      <Icon className="h-6 w-6 text-blue-400" />
                    </div>

                    <h2 className="text-lg font-semibold text-white">
                      {report.title}
                    </h2>

                    <p className="mt-2 text-sm leading-6 text-slate-400">
                      {report.description}
                    </p>

                    <div className="mt-5 text-sm font-medium text-blue-400">
                      Open Report →
                    </div>
                  </button>
                );
              })}
            </div>
          </>
        ) : (
          <>
            <div className="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
              <button
                type="button"
                onClick={() => setSelectedReport(null)}
                className="inline-flex w-fit items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-sm text-slate-300 transition hover:border-slate-600 hover:text-white"
              >
                <ArrowLeft className="h-4 w-4" />
                All Reports
              </button>

              <div>
                <h1 className="text-xl font-bold sm:text-2xl">
                  {selectedReport.title}
                </h1>
              </div>
            </div>

            <ReportFilters
              reportType={selectedReport.id}
              search={filters.search}
              selectedSubject={filters.selectedSubject}
              performance={filters.performance}
              status={filters.status}
              onSearchChange={handleSearchChange}
              onSubjectChange={handleSubjectChange}
              onPerformanceChange={handlePerformanceChange}
              onStatusChange={handleStatusChange}
              onClear={clearFilters}
            />

            <div className="mt-6">
              {renderSelectedReport()}
            </div>
          </>
        )}
      </div>
    </div>
  );
}

export default SchoolReports;