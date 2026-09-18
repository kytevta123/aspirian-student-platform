import { useState, useEffect } from "react";
import {
  FlaskConical,
  ArrowRight,
  ArrowLeft,
  ShieldAlert,
  ListChecks,
  Paperclip,
  Send,
  Loader2,
  CheckCircle2,
  Clock,
} from "lucide-react";
import Header from "../components/Header.jsx";
import Footer from "../components/Footer.jsx";

const API_BASE = "https://api-student.aspirian.pk/api";

// TEMP: replace with real auth token from your login flow once available
const TEMP_TOKEN = "1|Op8hzDukGubCkskmFy4ji6sPlTp92Yr14dI39voG92e58af8";

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
  const isFormData = options.body instanceof FormData;
  const res = await fetch(`${API_BASE}${path}`, {
    ...options,
    headers: {
      Accept: "application/json",
      Authorization: `Bearer ${TEMP_TOKEN}`,
      ...(isFormData ? {} : { "Content-Type": "application/json" }),
      ...(options.headers || {}),
    },
  });
  if (!res.ok) throw new Error(`Request failed: ${res.status}`);
  return res.json();
}

const categoryColors = {
  experiment: C.teal,
  exercise: C.orange,
  project: C.coral,
  workshop: C.green,
  simulation: C.teal,
  field_work: C.orange,
};

export default function Practicals() {
  const [stage, setStage] = useState("list"); // list | detail | working | result
  const [practicals, setPracticals] = useState([]);
  const [loadingList, setLoadingList] = useState(true);
  const [selected, setSelected] = useState(null);
  const [submission, setSubmission] = useState(null);
  const [safetyOk, setSafetyOk] = useState(false);
  const [reportText, setReportText] = useState("");
  const [file, setFile] = useState(null);
  const [submitting, setSubmitting] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    loadPracticals();
  }, []);

  async function loadPracticals() {
    setLoadingList(true);
    try {
      const data = await api("/practicals");
      setPracticals(data.data || []);
    } catch (e) {
      setError("Could not load practicals.");
    } finally {
      setLoadingList(false);
    }
  }

  function openPractical(p) {
    setSelected(p);
    setSafetyOk(false);
    setError(null);
    setStage("detail");
  }

  async function startPractical() {
    setError(null);
    try {
      const sub = await api(`/practicals/${selected.id}/start`, { method: "POST" });
      setSubmission(sub);
      setReportText("");
      setFile(null);
      setStage("working");
    } catch (e) {
      setError("Could not start this practical. Please try again.");
    }
  }

  async function submitReport() {
    if (!reportText.trim() && !file) return;
    setSubmitting(true);
    setError(null);
    try {
      const formData = new FormData();
      if (reportText.trim()) formData.append("report_text", reportText);
      if (file) formData.append("media", file);

      const updated = await api(`/practicals/submissions/${submission.id}/submit`, {
        method: "POST",
        body: formData,
      });
      setSubmission(updated);
      setStage("result");
    } catch (e) {
      setError("Could not submit your report. Please try again.");
    } finally {
      setSubmitting(false);
    }
  }

  function backToList() {
    setStage("list");
    setSelected(null);
    setSubmission(null);
    setReportText("");
    setFile(null);
    setError(null);
  }

  return (
    <div style={{ fontFamily: "Inter, sans-serif", color: C.ink }} className="min-h-screen bg-white">
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap');
        .font-display { font-family: 'Baloo 2', sans-serif; }
      `}</style>
      <Header />

      {/* ============ LIST ============ */}
      {stage === "list" && (
        <>
          <section
            className="px-6 py-16 text-center md:py-20"
            style={{ background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 45%, ${C.teal} 100%)` }}
          >
            <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-full" style={{ backgroundColor: C.coral }}>
              <FlaskConical size={36} color="white" />
            </div>
            <h1 className="font-display mt-6 text-3xl font-extrabold text-white md:text-4xl">
              Hands-on Practicals
            </h1>
            <p className="mx-auto mt-3 max-w-md text-white/75">
              Follow real instructions, do the work, and submit your report — just like a proper lab.
            </p>
          </section>

          <section className="mx-auto max-w-4xl px-6 py-12">
            {loadingList && (
              <div className="flex flex-col items-center gap-3 py-16">
                <Loader2 size={32} className="animate-spin" color={C.teal} />
                <p className="font-semibold" style={{ color: `${C.ink}99` }}>Loading practicals…</p>
              </div>
            )}

            {!loadingList && practicals.length === 0 && (
              <p className="py-16 text-center font-semibold" style={{ color: `${C.ink}80` }}>
                No practicals available yet. Check back soon!
              </p>
            )}

            <div className="grid gap-4 sm:grid-cols-2">
              {practicals.map((p) => {
                const color = categoryColors[p.category] || C.teal;
                return (
                  <button
                    key={p.id}
                    onClick={() => openPractical(p)}
                    className="rounded-2xl p-6 text-left transition hover:-translate-y-0.5"
                    style={{ backgroundColor: `${color}0F`, boxShadow: "0 4px 16px -8px rgba(11,37,69,0.15)" }}
                  >
                    <span
                      className="inline-block rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide"
                      style={{ backgroundColor: `${color}22`, color }}
                    >
                      {p.category.replace("_", " ")}
                    </span>
                    <h3 className="font-display mt-3 text-lg font-bold" style={{ color: C.navy }}>{p.title}</h3>
                    {p.description && (
                      <p className="mt-1 text-sm" style={{ color: `${C.ink}99` }}>{p.description}</p>
                    )}
                    <div className="mt-4 flex items-center gap-1.5 text-sm font-bold" style={{ color }}>
                      Start practical <ArrowRight size={14} />
                    </div>
                  </button>
                );
              })}
            </div>
          </section>
        </>
      )}

      {/* ============ DETAIL ============ */}
      {stage === "detail" && selected && (
        <section className="mx-auto max-w-2xl px-6 py-12">
          <button onClick={backToList} className="mb-6 flex items-center gap-1.5 text-sm font-bold" style={{ color: C.teal }}>
            <ArrowLeft size={16} /> All practicals
          </button>

          <span
            className="inline-block rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide"
            style={{ backgroundColor: `${categoryColors[selected.category] || C.teal}22`, color: categoryColors[selected.category] || C.teal }}
          >
            {selected.category.replace("_", " ")} · {selected.difficulty}
          </span>

          <h1 className="font-display mt-3 text-3xl font-extrabold" style={{ color: C.navy }}>{selected.title}</h1>
          {selected.description && <p className="mt-2 text-lg" style={{ color: `${C.ink}99` }}>{selected.description}</p>}

          {selected.instructions && (
            <div className="mt-6 rounded-2xl p-6" style={{ backgroundColor: "#F7FAFD" }}>
              <div className="flex items-center gap-2 font-bold" style={{ color: C.navy }}>
                <ListChecks size={18} /> Instructions
              </div>
              <p className="mt-2 whitespace-pre-line" style={{ color: `${C.ink}CC` }}>{selected.instructions}</p>
            </div>
          )}

          {selected.materials && (
            <div className="mt-4 rounded-2xl p-6" style={{ backgroundColor: "#F7FAFD" }}>
              <div className="flex items-center gap-2 font-bold" style={{ color: C.navy }}>
                <Paperclip size={18} /> Materials needed
              </div>
              <p className="mt-2 whitespace-pre-line" style={{ color: `${C.ink}CC` }}>{selected.materials}</p>
            </div>
          )}

          {selected.safety_instructions && (
            <div className="mt-4 rounded-2xl border-2 p-6" style={{ borderColor: `${C.coral}40`, backgroundColor: `${C.coral}0A` }}>
              <div className="flex items-center gap-2 font-bold" style={{ color: C.coral }}>
                <ShieldAlert size={18} /> Safety instructions
              </div>
              <p className="mt-2 whitespace-pre-line" style={{ color: `${C.ink}CC` }}>{selected.safety_instructions}</p>
              <label className="mt-4 flex items-center gap-2 text-sm font-semibold" style={{ color: C.ink }}>
                <input type="checkbox" checked={safetyOk} onChange={(e) => setSafetyOk(e.target.checked)} />
                I have read and understood the safety instructions
              </label>
            </div>
          )}

          <button
            onClick={startPractical}
            disabled={selected.safety_instructions && !safetyOk}
            className="mt-8 flex w-full items-center justify-center gap-2 rounded-full py-4 text-base font-bold text-white shadow-lg transition hover:opacity-90 disabled:opacity-40"
            style={{ backgroundColor: C.coral }}
          >
            Start Practical <ArrowRight size={18} />
          </button>
          {error && <p className="mt-3 text-center text-sm font-semibold text-red-500">{error}</p>}
        </section>
      )}

      {/* ============ WORKING (submit report) ============ */}
      {stage === "working" && selected && (
        <section className="mx-auto max-w-2xl px-6 py-12">
          <span
            className="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-sm font-semibold"
            style={{ backgroundColor: `${C.green}1A`, color: C.green }}
          >
            <Clock size={14} /> In progress · Attempt {submission?.attempt_number}
          </span>

          <h1 className="font-display mt-3 text-2xl font-extrabold" style={{ color: C.navy }}>{selected.title}</h1>
          <p className="mt-1" style={{ color: `${C.ink}99` }}>Record your observations and results below.</p>

          <div className="mt-6 rounded-2xl p-6" style={{ backgroundColor: "white", boxShadow: "0 8px 24px -12px rgba(11,37,69,0.2)" }}>
            <label className="text-sm font-bold" style={{ color: C.navy }}>Your report</label>
            <textarea
              value={reportText}
              onChange={(e) => setReportText(e.target.value)}
              placeholder="Objective, procedure, observations, results, conclusion…"
              rows={8}
              className="mt-2 w-full resize-none rounded-2xl border-2 p-4 text-base outline-none"
              style={{ borderColor: "#EAF1F8", color: C.ink }}
            />

            <label className="mt-4 flex items-center justify-between rounded-xl border-2 border-dashed p-4 text-sm font-semibold cursor-pointer" style={{ borderColor: "#EAF1F8", color: `${C.ink}99` }}>
              <span className="flex items-center gap-2">
                <Paperclip size={16} /> {file ? file.name : "Attach a photo, document, or file (optional)"}
              </span>
              <input
                type="file"
                className="hidden"
                onChange={(e) => setFile(e.target.files?.[0] || null)}
              />
            </label>

            <button
              onClick={submitReport}
              disabled={submitting || (!reportText.trim() && !file)}
              className="mt-5 flex w-full items-center justify-center gap-2 rounded-full py-3.5 text-base font-bold text-white transition disabled:opacity-40"
              style={{ backgroundColor: C.teal }}
            >
              {submitting ? (
                <>
                  <Loader2 size={18} className="animate-spin" /> Submitting…
                </>
              ) : (
                <>
                  Submit Report <Send size={16} />
                </>
              )}
            </button>
          </div>
          {error && <p className="mt-3 text-center text-sm font-semibold text-red-500">{error}</p>}
        </section>
      )}

      {/* ============ RESULT ============ */}
      {stage === "result" && submission && (
        <section className="mx-auto max-w-xl px-6 py-16 text-center">
          <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-full" style={{ backgroundColor: C.green }}>
            <CheckCircle2 size={36} color="white" />
          </div>
          <h2 className="font-display mt-6 text-3xl font-extrabold" style={{ color: C.navy }}>Report submitted!</h2>
          <p className="mt-2" style={{ color: `${C.ink}99` }}>
            Your practical report has been submitted and is awaiting review.
          </p>

          <div className="mt-8 rounded-2xl p-6 text-left" style={{ backgroundColor: "#F7FAFD" }}>
            <p className="text-sm font-bold" style={{ color: C.teal }}>Your report</p>
            <p className="mt-2 whitespace-pre-line" style={{ color: `${C.ink}CC` }}>{submission.report_text}</p>
            {submission.media_url && (
              <p className="mt-3 flex items-center gap-1.5 text-sm font-semibold" style={{ color: C.navy }}>
                <Paperclip size={14} /> Attachment uploaded
              </p>
            )}
          </div>

          <button
            onClick={backToList}
            className="mt-8 flex items-center gap-2 rounded-full px-7 py-3.5 text-base font-bold text-white shadow-lg transition hover:opacity-90 mx-auto"
            style={{ backgroundColor: C.coral }}
          >
            Browse more practicals <ArrowRight size={18} />
          </button>
        </section>
      )}

      <Footer />
    </div>
  );
}