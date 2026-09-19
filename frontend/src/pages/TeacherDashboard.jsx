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
  Plus,
  Pencil,
  Trash2,
  CheckCircle2,
  Search,
  X,
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

async function api(path, options = {}) {
  const res = await fetch(`${API_BASE}${path}`, {
    ...options,
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
      Authorization: `Bearer ${TEMP_TOKEN}`,
      ...(options.headers || {}),
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

  const [qSearch, setQSearch] = useState("");
  const [showQForm, setShowQForm] = useState(false);
  const [editingQ, setEditingQ] = useState(null); // null = creating new
  const [qForm, setQForm] = useState({ topic_id: "", question_type: "mcq", question_text: "", answer: "", explanation: "", marks: 1, difficulty: "easy" });
  const [qSaving, setQSaving] = useState(false);

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

  async function loadQuestions(search = "") {
    const query = search ? `?search=${encodeURIComponent(search)}` : "";
    const d = await api(`/teacher/questions${query}`);
    setQuestions(d.data);
  }

  function openNewQuestionForm() {
    setEditingQ(null);
    setQForm({ topic_id: "", question_type: "mcq", question_text: "", answer: "", explanation: "", marks: 1, difficulty: "easy" });
    setShowQForm(true);
  }

  function openEditQuestionForm(q) {
    setEditingQ(q);
    setQForm({
      topic_id: q.topic_id ?? "",
      question_type: q.question_type ?? "mcq",
      question_text: q.question_text ?? "",
      answer: q.answer ?? "",
      explanation: q.explanation ?? "",
      marks: q.marks ?? 1,
      difficulty: q.difficulty ?? "easy",
    });
    setShowQForm(true);
  }

  async function saveQuestion() {
    setQSaving(true);
    try {
      if (editingQ) {
        await api(`/teacher/questions/${editingQ.id}`, { method: "PUT", body: JSON.stringify(qForm) });
      } else {
        await api("/teacher/questions", { method: "POST", body: JSON.stringify(qForm) });
      }
      setShowQForm(false);
      await loadQuestions(qSearch);
    } catch (e) {
      alert("Could not save the question. Please check the fields and try again.");
    } finally {
      setQSaving(false);
    }
  }

  async function publishQuestion(id) {
    await api(`/teacher/questions/${id}/publish`, { method: "POST" });
    await loadQuestions(qSearch);
  }

  async function deleteQuestion(id) {
    if (!confirm("Delete this question?")) return;
    await api(`/teacher/questions/${id}`, { method: "DELETE" });
    await loadQuestions(qSearch);
  }

  async function loadTab(key) {
    setTab(key);
    if (key === "students" && !students) {
      const d = await api("/teacher/students");
      setStudents(d.data);
    }
    if (key === "questions" && !questions) {
      await loadQuestions();
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
              <div>
                <div className="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                  <div className="flex items-center gap-2 rounded-xl border-2 px-3 py-2" style={{ borderColor: "#EAF1F8" }}>
                    <Search size={16} color={`${C.ink}80`} />
                    <input
                      value={qSearch}
                      onChange={(e) => setQSearch(e.target.value)}
                      onKeyDown={(e) => e.key === "Enter" && loadQuestions(qSearch)}
                      placeholder="Search questions…"
                      className="w-full text-sm outline-none sm:w-64"
                    />
                  </div>
                  <button
                    onClick={openNewQuestionForm}
                    className="flex items-center justify-center gap-1.5 rounded-full px-4 py-2.5 text-sm font-bold text-white"
                    style={{ backgroundColor: C.coral }}
                  >
                    <Plus size={16} /> New Question
                  </button>
                </div>

                <DataTable
                  columns={["Question", "Type", "Difficulty", "Marks", "Status", "Actions"]}
                  rows={questions}
                  renderRow={(q) => (
                    <tr key={q.id} className="border-t" style={{ borderColor: "#F0F4F8" }}>
                      <td className="px-4 py-3 font-semibold" style={{ color: C.navy }}>{q.question_text}</td>
                      <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{q.question_type}</td>
                      <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{q.difficulty}</td>
                      <td className="px-4 py-3" style={{ color: `${C.ink}99` }}>{q.marks}</td>
                      <td className="px-4 py-3">
                        <span
                          className="rounded-full px-2.5 py-1 text-xs font-bold"
                          style={{
                            backgroundColor: q.status === "published" ? `${C.green}1A` : `${C.orange}1A`,
                            color: q.status === "published" ? C.green : C.orange,
                          }}
                        >
                          {q.status}
                        </span>
                      </td>
                      <td className="px-4 py-3">
                        <div className="flex items-center gap-3">
                          <button onClick={() => openEditQuestionForm(q)} title="Edit" style={{ color: C.teal }}>
                            <Pencil size={16} />
                          </button>
                          {q.status !== "published" && (
                            <button onClick={() => publishQuestion(q.id)} title="Publish" style={{ color: C.green }}>
                              <CheckCircle2 size={16} />
                            </button>
                          )}
                          <button onClick={() => deleteQuestion(q.id)} title="Delete" style={{ color: C.coral }}>
                            <Trash2 size={16} />
                          </button>
                        </div>
                      </td>
                    </tr>
                  )}
                />
              </div>
            )}

            {/* QUESTION FORM MODAL */}
            {showQForm && (
              <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
                <div className="w-full max-w-lg rounded-2xl bg-white p-6" style={{ boxShadow: "0 20px 60px -20px rgba(0,0,0,0.4)" }}>
                  <div className="mb-4 flex items-center justify-between">
                    <h3 className="font-display text-xl font-bold" style={{ color: C.navy }}>
                      {editingQ ? "Edit Question" : "New Question"}
                    </h3>
                    <button onClick={() => setShowQForm(false)}><X size={20} color={`${C.ink}80`} /></button>
                  </div>

                  <div className="space-y-3">
                    <div>
                      <label className="text-xs font-bold" style={{ color: `${C.ink}80` }}>Topic ID</label>
                      <input
                        type="number"
                        value={qForm.topic_id}
                        onChange={(e) => setQForm({ ...qForm, topic_id: e.target.value })}
                        className="mt-1 w-full rounded-xl border-2 p-2.5 text-sm outline-none"
                        style={{ borderColor: "#EAF1F8" }}
                      />
                    </div>
                    <div>
                      <label className="text-xs font-bold" style={{ color: `${C.ink}80` }}>Question Text</label>
                      <textarea
                        value={qForm.question_text}
                        onChange={(e) => setQForm({ ...qForm, question_text: e.target.value })}
                        rows={3}
                        className="mt-1 w-full resize-none rounded-xl border-2 p-2.5 text-sm outline-none"
                        style={{ borderColor: "#EAF1F8" }}
                      />
                    </div>
                    <div className="grid grid-cols-2 gap-3">
                      <div>
                        <label className="text-xs font-bold" style={{ color: `${C.ink}80` }}>Type</label>
                        <select
                          value={qForm.question_type}
                          onChange={(e) => setQForm({ ...qForm, question_type: e.target.value })}
                          className="mt-1 w-full rounded-xl border-2 p-2.5 text-sm outline-none"
                          style={{ borderColor: "#EAF1F8" }}
                        >
                          <option value="mcq">MCQ</option>
                          <option value="short">Short</option>
                          <option value="long">Long</option>
                        </select>
                      </div>
                      <div>
                        <label className="text-xs font-bold" style={{ color: `${C.ink}80` }}>Difficulty</label>
                        <select
                          value={qForm.difficulty}
                          onChange={(e) => setQForm({ ...qForm, difficulty: e.target.value })}
                          className="mt-1 w-full rounded-xl border-2 p-2.5 text-sm outline-none"
                          style={{ borderColor: "#EAF1F8" }}
                        >
                          <option value="easy">Easy</option>
                          <option value="medium">Medium</option>
                          <option value="hard">Hard</option>
                        </select>
                      </div>
                    </div>
                    <div>
                      <label className="text-xs font-bold" style={{ color: `${C.ink}80` }}>Answer</label>
                      <input
                        value={qForm.answer}
                        onChange={(e) => setQForm({ ...qForm, answer: e.target.value })}
                        className="mt-1 w-full rounded-xl border-2 p-2.5 text-sm outline-none"
                        style={{ borderColor: "#EAF1F8" }}
                      />
                    </div>
                    <div>
                      <label className="text-xs font-bold" style={{ color: `${C.ink}80` }}>Explanation</label>
                      <textarea
                        value={qForm.explanation}
                        onChange={(e) => setQForm({ ...qForm, explanation: e.target.value })}
                        rows={2}
                        className="mt-1 w-full resize-none rounded-xl border-2 p-2.5 text-sm outline-none"
                        style={{ borderColor: "#EAF1F8" }}
                      />
                    </div>
                    <div>
                      <label className="text-xs font-bold" style={{ color: `${C.ink}80` }}>Marks</label>
                      <input
                        type="number"
                        value={qForm.marks}
                        onChange={(e) => setQForm({ ...qForm, marks: e.target.value })}
                        className="mt-1 w-full rounded-xl border-2 p-2.5 text-sm outline-none"
                        style={{ borderColor: "#EAF1F8" }}
                      />
                    </div>
                  </div>

                  <button
                    onClick={saveQuestion}
                    disabled={qSaving || !qForm.topic_id || !qForm.question_text}
                    className="mt-5 flex w-full items-center justify-center gap-2 rounded-full py-3 text-sm font-bold text-white disabled:opacity-40"
                    style={{ backgroundColor: C.teal }}
                  >
                    {qSaving ? <Loader2 size={16} className="animate-spin" /> : (editingQ ? "Save Changes" : "Create Question")}
                  </button>
                </div>
              </div>
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