import { useState, useEffect } from "react";
import {
  LayoutDashboard,
  Users,
  Layers,
  ClipboardList,
  BarChart3,
  TrendingUp,
  Loader2,
  GraduationCap,
} from "lucide-react";
import Header from "../components/Header.jsx";
import Footer from "../components/Footer.jsx";

const API_BASE = "https://api-student.aspirian.pk/api";

// TEMP: replace with real auth token from your login flow once available
const TEMP_TOKEN = "2|gARj5NTYk3p457xiheifAxmpqQp2znzpCGZqUREW6e2cc171";

const C = {
  navyDark: "#071B24",
  navy: "#0B2E35",
  teal: "#0F6E6B",
  coral: "#F2453F",
  green: "#17D67D",
  orange: "#FF9F1C",
  ink: "#0B2545",
};

async function api(path) {
  const res = await fetch(`${API_BASE}${path}`, {
    headers: {
      Accept: "application/json",
      Authorization: `Bearer ${TEMP_TOKEN}`,
    },
  });
  if (!res.ok) throw new Error(`Request failed: ${res.status}`);
  return res.json();
}

const tabs = [
  { key: "overview", label: "Overview", icon: LayoutDashboard },
  { key: "students", label: "Students", icon: Users },
  { key: "questions", label: "Questions", icon: Layers },
  { key: "tests", label: "Tests", icon: ClipboardList },
  { key: "results", label: "Results", icon: BarChart3 },
];

function StatCard({ label, value, color, icon: Icon }) {
  return (
    <div className="rounded-2xl p-5" style={{ backgroundColor: `${color}0F` }}>
      <div className="flex h-10 w-10 items-center justify-center rounded-xl" style={{ backgroundColor: color }}>
        <Icon size={18} color="white" />
      </div>
      <p className="font-display mt-3 text-2xl font-extrabold" style={{ color: C.navy }}>{value ?? "—"}</p>
      <p className="text-sm font-semibold" style={{ color: `${C.ink}80` }}>{label}</p>
    </div>
  );
}

function EmptyState({ text }) {
  return <p className="py-10 text-center font-semibold" style={{ color: `${C.ink}66` }}>{text}</p>;
}

function DataTable({ columns, rows, renderRow }) {
  if (!rows || rows.length === 0) return <EmptyState text="Nothing here yet." />;
  return (
    <div className="overflow-x-auto rounded-2xl" style={{ backgroundColor: "white", boxShadow: "0 8px 24px -14px rgba(11,37,69,0.2)" }}>
      <table className="w-full text-left text-sm">
        <thead>
          <tr style={{ backgroundColor: "#F7FAFD" }}>
            {columns.map((c) => (
              <th key={c} className="px-4 py-3 font-bold" style={{ color: C.navy }}>{c}</th>
            ))}
          </tr>
        </thead>
        <tbody>{rows.map(renderRow)}</tbody>
      </table>
    </div>
  );
}

export default function TeacherDashboard() {
  const [tab, setTab] = useState("overview");
  const [profile, setProfile] = useState(null);
  const [reports, setReports] = useState(null);
  const [students, setStudents] = useState(null);
  const [questions, setQuestions] = useState(null);
  const [tests, setTests] = useState(null);
  const [results, setResults] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [forbidden, setForbidden] = useState(false);

  useEffect(() => {
    loadOverview();
  }, []);

  async function loadOverview() {
    setLoading(true);
    setError(null);
    try {
      const [p, r] = await Promise.all([api("/teacher/profile"), api("/teacher/reports")]);
      setProfile(p);
      setReports(r);
    } catch (e) {
      if (String(e.message).includes("403")) setForbidden(true);
      else setError("Could not load the dashboard.");
    } finally {
      setLoading(false);
    }
  }

  async function loadTab(key) {
    setTab(key);
    if (key === "students" && !students) {
      const d = await api("/teacher/students");
      setStudents(d.data);
    }
    if (key === "questions" && !questions) {
      const d = await api("/teacher/questions");
      setQuestions(d.data);
    }
    if (key === "tests" && !tests) {
      const d = await api("/teacher/tests");
      setTests(d.data);
    }
    if (key === "results" && !results) {
      const d = await api("/teacher/results");
      setResults(d.data);
    }
  }

  return (
    <div style={{ fontFamily: "Inter, sans-serif", color: C.ink }} className="min-h-screen bg-white">
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap');
        .font-display { font-family: 'Baloo 2', sans-serif; }
      `}</style>
      <Header />

      <section
        className="px-6 py-10 md:py-14"
        style={{ background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 45%, ${C.teal} 100%)` }}
      >
        <div className="mx-auto max-w-5xl">
          <div className="flex items-center gap-3">
            <div className="flex h-12 w-12 items-center justify-center rounded-2xl" style={{ backgroundColor: C.coral }}>
              <GraduationCap size={24} color="white" />
            </div>
            <div>
              <p className="text-sm font-semibold text-white/60">Teacher Dashboard</p>
              <h1 className="font-display text-2xl font-extrabold text-white md:text-3xl">
                {profile ? `Welcome, ${profile.name}` : "Welcome"}
              </h1>
            </div>
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-5xl px-6 py-8">
        {loading && (
          <div className="flex flex-col items-center gap-3 py-16">
            <Loader2 size={32} className="animate-spin" color={C.teal} />
            <p className="font-semibold" style={{ color: `${C.ink}99` }}>Loading dashboard…</p>
          </div>
        )}

        {forbidden && (
          <div className="rounded-2xl p-8 text-center" style={{ backgroundColor: `${C.coral}0F` }}>
            <p className="font-bold" style={{ color: C.coral }}>You don't have teacher access.</p>
            <p className="mt-2 text-sm" style={{ color: `${C.ink}99` }}>This dashboard is only visible to accounts with the Teacher role.</p>
          </div>
        )}

        {error && <EmptyState text={error} />}

        {!loading && !forbidden && !error && (
          <>
            {/* Tabs */}
            <div className="mb-6 flex flex-wrap gap-2 border-b" style={{ borderColor: "#EAF1F8" }}>
              {tabs.map((t) => (
                <button
                  key={t.key}
                  onClick={() => loadTab(t.key)}
                  className="flex items-center gap-1.5 border-b-2 px-4 py-3 text-sm font-bold transition"
                  style={{
                    borderColor: tab === t.key ? C.coral : "transparent",
                    color: tab === t.key ? C.coral : `${C.ink}80`,
                  }}
                >
                  <t.icon size={16} /> {t.label}
                </button>
              ))}
            </div>

            {/* OVERVIEW */}
            {tab === "overview" && reports && (
              <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
                <StatCard label="Total Students" value={reports.total_students} color={C.teal} icon={Users} />
                <StatCard label="Total Tests" value={reports.total_tests} color={C.orange} icon={ClipboardList} />
                <StatCard label="Completion Rate" value={`${reports.completion_rate}%`} color={C.green} icon={TrendingUp} />
                <StatCard label="Average Score" value={reports.average_score ? `${reports.average_score}%` : "—"} color={C.coral} icon={BarChart3} />
              </div>
            )}

            {/* STUDENTS */}
            {tab === "students" && (
              <DataTable
                columns={["Name", "Email", "Status"]}
                rows={students}
                renderRow={(s) => (
                  <tr key={s.id} className="border-t" style={{ borderColor: "#F0F4F8" }}>
                    <td className="px-4 py-3 font-semibold" style={{ color: C.navy }}>{s.name}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{s.email}</td>
                    <td className="px-4 py-3">
                      <span className="rounded-full px-2.5 py-1 text-xs font-bold" style={{ backgroundColor: `${C.green}1A`, color: C.green }}>
                        {s.status}
                      </span>
                    </td>
                  </tr>
                )}
              />
            )}

            {/* QUESTIONS */}
            {tab === "questions" && (
              <DataTable
                columns={["Question", "Type", "Difficulty", "Marks"]}
                rows={questions}
                renderRow={(q) => (
                  <tr key={q.id} className="border-t" style={{ borderColor: "#F0F4F8" }}>
                    <td className="px-4 py-3 font-semibold" style={{ color: C.navy }}>{q.question_text}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{q.question_type}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{q.difficulty}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{q.marks}</td>
                  </tr>
                )}
              />
            )}

            {/* TESTS */}
            {tab === "tests" && (
              <DataTable
                columns={["Title", "Status", "Duration"]}
                rows={tests}
                renderRow={(t) => (
                  <tr key={t.id} className="border-t" style={{ borderColor: "#F0F4F8" }}>
                    <td className="px-4 py-3 font-semibold" style={{ color: C.navy }}>{t.title}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{t.status}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{t.duration ?? "—"}</td>
                  </tr>
                )}
              />
            )}

            {/* RESULTS */}
            {tab === "results" && (
              <DataTable
                columns={["Student", "Test", "Score", "Status"]}
                rows={results}
                renderRow={(r) => (
                  <tr key={r.id} className="border-t" style={{ borderColor: "#F0F4F8" }}>
                    <td className="px-4 py-3 font-semibold" style={{ color: C.navy }}>{r.user?.name ?? "—"}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{r.test?.title ?? "—"}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{r.status}</td>
                    <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{r.submitted_at ? "Submitted" : "In progress"}</td>
                  </tr>
                )}
              />
            )}
          </>
        )}
      </section>

      <Footer />
    </div>
  );
}