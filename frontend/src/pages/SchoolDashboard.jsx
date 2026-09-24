import { useState, useEffect } from "react";
import {
  LayoutDashboard,
  Users,
  GraduationCap,
  School as SchoolIcon,
  BarChart3,
  TrendingUp,
  Loader2,
  Building2,
  Plus,
  X,
} from "lucide-react";
import Header from "../components/Header.jsx";
import Footer from "../components/Footer.jsx";

const API_BASE = "https://api-student.aspirian.pk/api";

// TEMP: replace with real auth token from your login flow once available
const TEMP_TOKEN = "3|U9fTi4zPwEaVhwNJFuIp7w8v4r8LYnX7wX6pKzem1e4405e6";

// TEMP: replace with real school selection once multi-school support exists
const SCHOOL_ID = 1;

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
      ...(options.body ? { "Content-Type": "application/json" } : {}),
      Authorization: `Bearer ${TEMP_TOKEN}`,
      ...(options.headers || {}),
    },
  });

  let data = null;

  try {
    data = await res.json();
  } catch {
    data = null;
  }

  if (!res.ok) {
    const error = new Error(`Request failed: ${res.status}`);
    error.status = res.status;
    error.data = data;
    throw error;
  }

  return data;
}

const tabs = [
  { key: "overview", label: "Overview", icon: LayoutDashboard },
  { key: "students", label: "Students", icon: Users },
  { key: "teachers", label: "Teachers", icon: GraduationCap },
  { key: "classes", label: "Classes", icon: SchoolIcon },
];

function StatCard({ label, value, color, icon: Icon }) {
  return (
    <div
      className="rounded-2xl p-5"
      style={{ backgroundColor: `${color}0F` }}
    >
      <div
        className="flex h-10 w-10 items-center justify-center rounded-xl"
        style={{ backgroundColor: color }}
      >
        <Icon size={18} color="white" />
      </div>

      <p
        className="font-display mt-3 text-2xl font-extrabold"
        style={{ color: C.navy }}
      >
        {value ?? "—"}
      </p>

      <p
        className="text-sm font-semibold"
        style={{ color: `${C.ink}80` }}
      >
        {label}
      </p>
    </div>
  );
}

function EmptyState({ text }) {
  return (
    <p
      className="py-10 text-center font-semibold"
      style={{ color: `${C.ink}66` }}
    >
      {text}
    </p>
  );
}

function DataTable({ columns, rows, renderRow }) {
  if (!rows || rows.length === 0) {
    return <EmptyState text="Nothing here yet." />;
  }

  return (
    <div
      className="overflow-x-auto rounded-2xl"
      style={{
        backgroundColor: "white",
        boxShadow: "0 8px 24px -14px rgba(11,37,69,0.2)",
      }}
    >
      <table className="w-full text-left text-sm">
        <thead>
          <tr style={{ backgroundColor: "#F7FAFD" }}>
            {columns.map((c) => (
              <th
                key={c}
                className="px-4 py-3 font-bold"
                style={{ color: C.navy }}
              >
                {c}
              </th>
            ))}
          </tr>
        </thead>

        <tbody>{rows.map(renderRow)}</tbody>
      </table>
    </div>
  );
}

export default function SchoolDashboard() {
  const [tab, setTab] = useState("overview");

  const [overview, setOverview] = useState(null);
  const [performance, setPerformance] = useState(null);

  const [students, setStudents] = useState(null);
  const [teachers, setTeachers] = useState(null);
  const [classes, setClasses] = useState(null);

  // Student Management state
  const [showStudentForm, setShowStudentForm] = useState(false);

  const [studentForm, setStudentForm] = useState({
    name: "",
    email: "",
    password: "",
    school_class_id: "",
  });

  const [studentSaving, setStudentSaving] = useState(false);
  const [studentFormError, setStudentFormError] = useState(null);

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
      const [o, p] = await Promise.all([
        api(`/school/${SCHOOL_ID}`),
        api(`/school/${SCHOOL_ID}/performance`),
      ]);

      setOverview(o);
      setPerformance(p);
    } catch (e) {
      if (e.status === 403) {
        setForbidden(true);
      } else {
        setError("Could not load the dashboard.");
      }
    } finally {
      setLoading(false);
    }
  }

  async function loadStudents() {
    const d = await api(`/school/${SCHOOL_ID}/students`);
    setStudents(d.data || []);
  }

  async function loadClasses() {
    const d = await api(`/school/${SCHOOL_ID}/classes`);
    setClasses(d.data || []);
  }

  async function loadTab(key) {
    setTab(key);

    try {
      if (key === "students" && !students) {
        await loadStudents();
      }

      if (key === "teachers" && !teachers) {
        const d = await api(`/school/${SCHOOL_ID}/teachers`);
        setTeachers(d.data || []);
      }

      if (key === "classes" && !classes) {
        await loadClasses();
      }
    } catch (e) {
      if (e.status === 403) {
        setForbidden(true);
      } else {
        setError("Could not load this section.");
      }
    }
  }

  async function openStudentForm() {
    setStudentFormError(null);

    if (!classes) {
      try {
        await loadClasses();
      } catch (e) {
        if (e.status === 403) {
          setForbidden(true);
          return;
        }

        setStudentFormError(
          "Could not load classes. Please try again."
        );
        return;
      }
    }

    setShowStudentForm(true);
  }

  function closeStudentForm() {
    if (studentSaving) {
      return;
    }

    setShowStudentForm(false);

    setStudentForm({
      name: "",
      email: "",
      password: "",
      school_class_id: "",
    });

    setStudentFormError(null);
  }

  function handleStudentFormChange(e) {
    const { name, value } = e.target;

    setStudentForm((prev) => ({
      ...prev,
      [name]: value,
    }));

    if (studentFormError) {
      setStudentFormError(null);
    }
  }

  async function handleCreateStudent(e) {
    e.preventDefault();

    setStudentFormError(null);
    setStudentSaving(true);

    try {
      const payload = {
        name: studentForm.name.trim(),
        email: studentForm.email.trim(),
        password: studentForm.password,
        school_class_id: studentForm.school_class_id
          ? Number(studentForm.school_class_id)
          : null,
      };

      await api(`/school/${SCHOOL_ID}/students`, {
        method: "POST",
        body: JSON.stringify(payload),
      });

      await loadStudents();

      setShowStudentForm(false);

      setStudentForm({
        name: "",
        email: "",
        password: "",
        school_class_id: "",
      });

      setStudentFormError(null);
    } catch (e) {
      if (e.status === 422) {
        const validationErrors = e.data?.errors;

        if (validationErrors) {
          const firstError = Object.values(validationErrors)
            .flat()
            .find(Boolean);

          setStudentFormError(
            firstError || "Please check the entered information."
          );
        } else {
          setStudentFormError(
            e.data?.message ||
              "Please check the entered information."
          );
        }
      } else if (e.status === 403) {
        setStudentFormError(
          "You do not have permission to create students."
        );
      } else if (e.status === 401) {
        setStudentFormError(
          "Your login session is not valid. Please login again."
        );
      } else {
        setStudentFormError(
          e.data?.message ||
            "Could not create the student. Please try again."
        );
      }
    } finally {
      setStudentSaving(false);
    }
  }

  return (
    <div
      style={{
        fontFamily: "Inter, sans-serif",
        color: C.ink,
      }}
      className="min-h-screen bg-white"
    >
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap');

        .font-display {
          font-family: 'Baloo 2', sans-serif;
        }
      `}</style>

      <Header />

      <section
        className="px-6 py-10 md:py-14"
        style={{
          background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 45%, ${C.teal} 100%)`,
        }}
      >
        <div className="mx-auto max-w-5xl">
          <div className="flex items-center gap-3">
            <div
              className="flex h-12 w-12 items-center justify-center rounded-2xl"
              style={{ backgroundColor: C.coral }}
            >
              <Building2 size={24} color="white" />
            </div>

            <div>
              <p className="text-sm font-semibold text-white/60">
                School Dashboard
              </p>

              <h1 className="font-display text-2xl font-extrabold text-white md:text-3xl">
                {overview ? overview.school.name : "Welcome"}
              </h1>
            </div>
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-5xl px-6 py-8">
        {loading && (
          <div className="flex flex-col items-center gap-3 py-16">
            <Loader2
              size={32}
              className="animate-spin"
              color={C.teal}
            />

            <p
              className="font-semibold"
              style={{ color: `${C.ink}99` }}
            >
              Loading dashboard…
            </p>
          </div>
        )}

        {forbidden && (
          <div
            className="rounded-2xl p-8 text-center"
            style={{ backgroundColor: `${C.coral}0F` }}
          >
            <p
              className="font-bold"
              style={{ color: C.coral }}
            >
              You don't have school admin access.
            </p>

            <p
              className="mt-2 text-sm"
              style={{ color: `${C.ink}99` }}
            >
              This dashboard is only visible to accounts with the School Admin role.
            </p>
          </div>
        )}

        {error && <EmptyState text={error} />}

        {!loading && !forbidden && !error && (
          <>
            <div
              className="mb-6 flex flex-wrap gap-2 border-b"
              style={{ borderColor: "#EAF1F8" }}
            >
              {tabs.map((t) => (
                <button
                  key={t.key}
                  onClick={() => loadTab(t.key)}
                  className="flex items-center gap-1.5 border-b-2 px-4 py-3 text-sm font-bold transition"
                  style={{
                    borderColor:
                      tab === t.key ? C.coral : "transparent",
                    color:
                      tab === t.key ? C.coral : `${C.ink}80`,
                  }}
                >
                  <t.icon size={16} />
                  {t.label}
                </button>
              ))}
            </div>

            {/* OVERVIEW */}
            {tab === "overview" && overview && (
              <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
                <StatCard
                  label="Total Classes"
                  value={overview.total_classes}
                  color={C.teal}
                  icon={SchoolIcon}
                />

                <StatCard
                  label="Total Students"
                  value={overview.total_students}
                  color={C.orange}
                  icon={Users}
                />

                <StatCard
                  label="Test Results Recorded"
                  value={performance?.total_results}
                  color={C.green}
                  icon={TrendingUp}
                />

                <StatCard
                  label="Average Score"
                  value={
                    performance?.average_percentage
                      ? `${performance.average_percentage}%`
                      : "—"
                  }
                  color={C.coral}
                  icon={BarChart3}
                />
              </div>
            )}

            {/* STUDENTS */}
            {tab === "students" && (
              <div>
                <div className="mb-5 flex items-center justify-between gap-3">
                  <div>
                    <h2
                      className="font-display text-xl font-extrabold"
                      style={{ color: C.navy }}
                    >
                      Student Management
                    </h2>

                    <p
                      className="mt-1 text-sm"
                      style={{ color: `${C.ink}80` }}
                    >
                      Manage students enrolled in this school.
                    </p>
                  </div>

                  <button
                    onClick={openStudentForm}
                    className="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold text-white transition hover:opacity-90"
                    style={{ backgroundColor: C.teal }}
                  >
                    <Plus size={17} />
                    Add Student
                  </button>
                </div>

                <DataTable
                  columns={["Name", "Email", "Status"]}
                  rows={students}
                  renderRow={(s) => (
                    <tr
                      key={s.id}
                      className="border-t"
                      style={{ borderColor: "#F0F4F8" }}
                    >
                      <td
                        className="px-4 py-3 font-semibold"
                        style={{ color: C.navy }}
                      >
                        {s.user?.name ?? "—"}
                      </td>

                      <td
                        className="px-4 py-3"
                        style={{ color: `${C.ink}99` }}
                      >
                        {s.user?.email ?? "—"}
                      </td>

                      <td className="px-4 py-3">
                        <span
                          className="rounded-full px-2.5 py-1 text-xs font-bold"
                          style={{
                            backgroundColor: `${C.green}1A`,
                            color: C.green,
                          }}
                        >
                          {s.status}
                        </span>
                      </td>
                    </tr>
                  )}
                />
              </div>
            )}

            {/* TEACHERS */}
            {tab === "teachers" && (
              <DataTable
                columns={["Name", "Email", "Status"]}
                rows={teachers}
                renderRow={(t) => (
                  <tr
                    key={t.id}
                    className="border-t"
                    style={{ borderColor: "#F0F4F8" }}
                  >
                    <td
                      className="px-4 py-3 font-semibold"
                      style={{ color: C.navy }}
                    >
                      {t.name}
                    </td>

                    <td
                      className="px-4 py-3"
                      style={{ color: `${C.ink}99` }}
                    >
                      {t.email}
                    </td>

                    <td className="px-4 py-3">
                      <span
                        className="rounded-full px-2.5 py-1 text-xs font-bold"
                        style={{
                          backgroundColor: `${C.green}1A`,
                          color: C.green,
                        }}
                      >
                        {t.status}
                      </span>
                    </td>
                  </tr>
                )}
              />
            )}

            {/* CLASSES */}
            {tab === "classes" && (
              <DataTable
                columns={["Name", "Status"]}
                rows={classes}
                renderRow={(c) => (
                  <tr
                    key={c.id}
                    className="border-t"
                    style={{ borderColor: "#F0F4F8" }}
                  >
                    <td
                      className="px-4 py-3 font-semibold"
                      style={{ color: C.navy }}
                    >
                      {c.name}
                    </td>

                    <td
                      className="px-4 py-3"
                      style={{ color: `${C.ink}99` }}
                    >
                      {c.status}
                    </td>
                  </tr>
                )}
              />
            )}
          </>
        )}
      </section>

      {/* ADD STUDENT MODAL */}
      {showStudentForm && (
        <div
          className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 py-6"
          onClick={closeStudentForm}
        >
          <div
            className="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="mb-6 flex items-start justify-between gap-4">
              <div>
                <h2
                  className="font-display text-2xl font-extrabold"
                  style={{ color: C.navy }}
                >
                  Add New Student
                </h2>

                <p
                  className="mt-1 text-sm"
                  style={{ color: `${C.ink}80` }}
                >
                  Create a new student account for this school.
                </p>
              </div>

              <button
                type="button"
                onClick={closeStudentForm}
                disabled={studentSaving}
                className="flex h-9 w-9 items-center justify-center rounded-xl transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                style={{ color: C.ink }}
                aria-label="Close"
              >
                <X size={20} />
              </button>
            </div>

            <form onSubmit={handleCreateStudent} className="space-y-4">
              <div>
                <label
                  className="mb-1.5 block text-sm font-bold"
                  style={{ color: C.navy }}
                >
                  Student Name
                </label>

                <input
                  type="text"
                  name="name"
                  value={studentForm.name}
                  onChange={handleStudentFormChange}
                  placeholder="Enter student name"
                  className="w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2"
                  style={{
                    borderColor: "#DCE6EF",
                    color: C.ink,
                  }}
                  required
                />
              </div>

              <div>
                <label
                  className="mb-1.5 block text-sm font-bold"
                  style={{ color: C.navy }}
                >
                  Email Address
                </label>

                <input
                  type="email"
                  name="email"
                  value={studentForm.email}
                  onChange={handleStudentFormChange}
                  placeholder="student@example.com"
                  className="w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2"
                  style={{
                    borderColor: "#DCE6EF",
                    color: C.ink,
                  }}
                  required
                />
              </div>

              <div>
                <label
                  className="mb-1.5 block text-sm font-bold"
                  style={{ color: C.navy }}
                >
                  Password
                </label>

                <input
                  type="password"
                  name="password"
                  value={studentForm.password}
                  onChange={handleStudentFormChange}
                  placeholder="Enter temporary password"
                  minLength={6}
                  className="w-full rounded-xl border px-4 py-3 text-sm outline-none transition focus:ring-2"
                  style={{
                    borderColor: "#DCE6EF",
                    color: C.ink,
                  }}
                  required
                />

                <p
                  className="mt-1 text-xs"
                  style={{ color: `${C.ink}70` }}
                >
                  Minimum 6 characters.
                </p>
              </div>

              <div>
                <label
                  className="mb-1.5 block text-sm font-bold"
                  style={{ color: C.navy }}
                >
                  Class
                </label>

                <select
                  name="school_class_id"
                  value={studentForm.school_class_id}
                  onChange={handleStudentFormChange}
                  className="w-full rounded-xl border bg-white px-4 py-3 text-sm outline-none transition focus:ring-2"
                  style={{
                    borderColor: "#DCE6EF",
                    color: C.ink,
                  }}
                >
                  <option value="">Select class</option>

                  {classes?.map((schoolClass) => (
                    <option
                      key={schoolClass.id}
                      value={schoolClass.id}
                    >
                      {schoolClass.name}
                    </option>
                  ))}
                </select>
              </div>

              {studentFormError && (
                <div
                  className="rounded-xl px-4 py-3 text-sm font-semibold"
                  style={{
                    backgroundColor: `${C.coral}12`,
                    color: C.coral,
                  }}
                >
                  {studentFormError}
                </div>
              )}

              <div className="flex justify-end gap-3 pt-3">
                <button
                  type="button"
                  onClick={closeStudentForm}
                  disabled={studentSaving}
                  className="rounded-xl border px-5 py-2.5 text-sm font-bold transition hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50"
                  style={{
                    borderColor: "#DCE6EF",
                    color: C.ink,
                  }}
                >
                  Cancel
                </button>

                <button
                  type="submit"
                  disabled={studentSaving}
                  className="flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-60"
                  style={{ backgroundColor: C.teal }}
                >
                  {studentSaving && (
                    <Loader2 size={16} className="animate-spin" />
                  )}

                  {studentSaving ? "Creating..." : "Create Student"}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      <Footer />
    </div>
  );
}