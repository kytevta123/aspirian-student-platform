import { useState, useRef, useEffect } from "react";
import {
  Mic,
  Sparkles,
  ArrowRight,
  Clock,
  CheckCircle2,
  RotateCcw,
  Send,
  Loader2,
  MessageCircleQuestion,
  Trophy,
} from "lucide-react";

const API_BASE = "https://api-student.aspirian.pk/api";

// TEMP: replace with real auth token from your login flow once available
const TEMP_TOKEN = "1|Op8hzDukGubCkskmFy4ji6sPlTp92Yr14dI39voG92e58af8";

// ===== Aspirian Brand Palette (from aspirian.pk) =====
const C = {
  navyDark: "#071B24",
  navy: "#0B2E35",
  teal: "#0F6E6B",
  coral: "#F2453F",
  green: "#17D67D",
  orange: "#FF9F1C",
  white: "#FFFFFF",
  ink: "#0B2545",
};

async function api(path, options = {}) {
  const res = await fetch(`${API_BASE}${path}`, {
    ...options,
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      Authorization: `Bearer ${TEMP_TOKEN}`,
      ...(options.headers || {}),
    },
  });
  if (!res.ok) throw new Error(`Request failed: ${res.status}`);
  return res.json();
}

function Waveform() {
  const bars = [40, 65, 30, 80, 50, 90, 35, 70, 45, 60];
  return (
    <div className="flex items-end gap-1.5 h-24">
      {bars.map((h, i) => (
        <div
          key={i}
          className="w-2.5 rounded-full float-bar"
          style={{
            height: `${h}%`,
            backgroundColor: i % 3 === 0 ? C.coral : i % 3 === 1 ? C.green : C.orange,
            animationDelay: `${i * 0.12}s`,
          }}
        />
      ))}
    </div>
  );
}

function Timer({ seconds }) {
  const mins = Math.floor(seconds / 60);
  const secs = seconds % 60;
  return (
    <span className="tabular-nums">
      {String(mins).padStart(2, "0")}:{String(secs).padStart(2, "0")}
    </span>
  );
}

export default function Viva() {
  const [stage, setStage] = useState("hero");
  const [session, setSession] = useState(null);
  const [question, setQuestion] = useState(null);
  const [answer, setAnswer] = useState("");
  const [elapsed, setElapsed] = useState(0);
  const [result, setResult] = useState(null);
  const [error, setError] = useState(null);
  const timerRef = useRef(null);

  useEffect(() => {
    if (stage === "active") {
      timerRef.current = setInterval(() => setElapsed((e) => e + 1), 1000);
    } else {
      clearInterval(timerRef.current);
    }
    return () => clearInterval(timerRef.current);
  }, [stage]);

  async function startViva() {
    setStage("loading");
    setError(null);
    try {
      const newSession = await api("/viva/start", { method: "POST", body: JSON.stringify({}) });
      const data = await api(`/viva/${newSession.id}`);
      setSession(newSession);
      setQuestion(data.question);
      setElapsed(0);
      setAnswer("");
      setStage("active");
    } catch (e) {
      setError("Could not start viva. Please try again.");
      setStage("hero");
    }
  }

  async function submitAnswer() {
    if (!answer.trim() || !question) return;
    setStage("submitting");
    try {
      await api(`/viva/${session.id}/answer`, {
        method: "POST",
        body: JSON.stringify({
          question_id: question.id,
          answer_text: answer,
          duration_seconds: elapsed,
        }),
      });
      await api(`/viva/${session.id}/complete`, { method: "POST" });
      const full = await api(`/viva/${session.id}/result`);
      setResult(full);
      setStage("result");
    } catch (e) {
      setError("Could not submit your answer. Please try again.");
      setStage("active");
    }
  }

  function reset() {
    setStage("hero");
    setSession(null);
    setQuestion(null);
    setAnswer("");
    setElapsed(0);
    setResult(null);
    setError(null);
  }

  return (
    <div style={{ fontFamily: "Inter, sans-serif", color: C.ink }} className="min-h-screen bg-white">
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap');
        .font-display { font-family: 'Baloo 2', sans-serif; }
        @keyframes floatBar { 0%, 100% { transform: scaleY(0.6); } 50% { transform: scaleY(1); } }
        .float-bar { animation: floatBar 1.1s ease-in-out infinite; transform-origin: bottom; }
        @keyframes pulseRing {
          0% { box-shadow: 0 0 0 0 ${C.coral}59; }
          70% { box-shadow: 0 0 0 20px ${C.coral}00; }
          100% { box-shadow: 0 0 0 0 ${C.coral}00; }
        }
        .pulse-ring { animation: pulseRing 2s infinite; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.4s ease-out; }
      `}</style>

      {/* ============ HERO / INTRO ============ */}
      {stage === "hero" && (
        <section
          className="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-6 py-20 text-center"
          style={{ background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 45%, ${C.teal} 100%)` }}
        >
          <div className="mb-8 flex h-28 w-28 items-center justify-center rounded-full pulse-ring" style={{ backgroundColor: C.coral }}>
            <Mic size={48} color="white" strokeWidth={1.5} />
          </div>

          <span
            className="mb-4 inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-sm font-semibold"
            style={{ backgroundColor: `${C.green}22`, color: C.green }}
          >
            <Sparkles size={14} /> Viva Practice
          </span>

          <h1 className="font-display max-w-2xl text-4xl font-extrabold leading-tight text-white md:text-5xl">
            Practice speaking,
          </h1>
          <p className="font-display mt-1 text-3xl font-bold md:text-4xl" style={{ color: C.orange }}>
            master your subject.
          </p>

          <p className="mt-5 max-w-md text-lg text-white/75">
            Get asked real questions, answer in your own words, and build the
            confidence to explain what you know — out loud.
          </p>

          <div className="mt-8 flex flex-col items-center gap-3">
            <button
              onClick={startViva}
              className="flex items-center gap-2 rounded-full px-8 py-4 text-base font-bold text-white shadow-lg transition hover:opacity-90"
              style={{ backgroundColor: C.coral, boxShadow: `0 12px 24px -8px ${C.coral}80` }}
            >
              Start Viva Practice <ArrowRight size={18} />
            </button>
            {error && <p className="text-sm font-semibold" style={{ color: "#FF8A80" }}>{error}</p>}
          </div>

          <div className="mt-16">
            <Waveform />
          </div>
        </section>
      )}

      {/* ============ LOADING ============ */}
      {stage === "loading" && (
        <div
          className="flex min-h-screen flex-col items-center justify-center gap-4"
          style={{ background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 100%)` }}
        >
          <Loader2 size={40} className="animate-spin" color={C.green} />
          <p className="font-semibold text-white/70">Preparing your question…</p>
        </div>
      )}

      {/* ============ ACTIVE SESSION ============ */}
      {(stage === "active" || stage === "submitting") && question && (
        <section
          className="flex min-h-screen flex-col items-center justify-center px-6 py-12"
          style={{ background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 100%)` }}
        >
          <div className="fade-up w-full max-w-xl">
            <div className="mb-5 flex items-center justify-between">
              <span
                className="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-sm font-semibold"
                style={{ backgroundColor: `${C.coral}26`, color: "#FF8A80" }}
              >
                <MessageCircleQuestion size={14} /> Question 1
              </span>
              <span
                className="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-sm font-bold text-white"
                style={{ backgroundColor: "#ffffff14" }}
              >
                <Clock size={14} /> <Timer seconds={elapsed} />
              </span>
            </div>

            <div className="rounded-3xl p-8" style={{ backgroundColor: "white", boxShadow: "0 12px 30px -10px rgba(0,0,0,0.4)" }}>
              <p className="font-display text-2xl font-bold leading-snug" style={{ color: C.navy }}>
                {question.question_text}
              </p>

              <textarea
                value={answer}
                onChange={(e) => setAnswer(e.target.value)}
                placeholder="Type your answer as if you were saying it out loud…"
                rows={6}
                disabled={stage === "submitting"}
                className="mt-6 w-full resize-none rounded-2xl border-2 p-4 text-base outline-none transition"
                style={{ borderColor: "#EAF1F8", color: C.ink }}
                onFocus={(e) => (e.target.style.borderColor = C.teal)}
                onBlur={(e) => (e.target.style.borderColor = "#EAF1F8")}
              />

              <button
                onClick={submitAnswer}
                disabled={!answer.trim() || stage === "submitting"}
                className="mt-5 flex w-full items-center justify-center gap-2 rounded-full py-3.5 text-base font-bold text-white transition disabled:opacity-40"
                style={{ backgroundColor: C.teal }}
              >
                {stage === "submitting" ? (
                  <>
                    <Loader2 size={18} className="animate-spin" /> Submitting…
                  </>
                ) : (
                  <>
                    Submit Answer <Send size={16} />
                  </>
                )}
              </button>
            </div>

            {error && <p className="mt-3 text-center text-sm font-semibold" style={{ color: "#FF8A80" }}>{error}</p>}
          </div>
        </section>
      )}

      {/* ============ RESULT ============ */}
      {stage === "result" && result && (
        <section
          className="flex min-h-screen flex-col items-center justify-center px-6 py-12 text-center"
          style={{ background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 100%)` }}
        >
          <div className="fade-up flex h-20 w-20 items-center justify-center rounded-full" style={{ backgroundColor: C.green }}>
            <Trophy size={36} color="white" />
          </div>

          <h2 className="font-display mt-6 text-3xl font-extrabold text-white">Nicely done!</h2>
          <p className="mt-2 max-w-md text-white/70">
            You answered {result.responses.length} question{result.responses.length !== 1 ? "s" : ""} out loud. Keep practicing to build fluency.
          </p>

          <div className="mt-8 w-full max-w-xl space-y-4 text-left">
            {result.responses.map((r) => (
              <div key={r.id} className="rounded-2xl p-6" style={{ backgroundColor: "white", boxShadow: "0 8px 20px -8px rgba(0,0,0,0.3)" }}>
                <p className="text-sm font-bold" style={{ color: C.teal }}>{r.question.question_text}</p>
                <p className="mt-2" style={{ color: `${C.ink}CC` }}>{r.answer_text}</p>
                <div className="mt-3 flex items-center gap-1.5 text-sm" style={{ color: `${C.ink}80` }}>
                  <CheckCircle2 size={14} color={C.green} /> Answered in {r.duration_seconds}s
                </div>
              </div>
            ))}
          </div>

          <button
            onClick={reset}
            className="mt-8 flex items-center gap-2 rounded-full px-7 py-3.5 text-base font-bold text-white shadow-lg transition hover:opacity-90"
            style={{ backgroundColor: C.coral }}
          >
            <RotateCcw size={18} /> Practice Again
          </button>
        </section>
      )}
    </div>
  );
}