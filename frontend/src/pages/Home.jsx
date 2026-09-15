import { useState } from "react";
import {
  Sparkles,
  BookOpen,
  Brain,
  FlaskConical,
  Trophy,
  Timer,
  Layers,
  PenLine,
  ArrowRight,
  Menu,
  X,
  CheckCircle2,
  Flame,
} from "lucide-react";

const subjects = [
  { name: "Physics", color: "#2E6F95" },
  { name: "Chemistry", color: "#2FBF8F" },
  { name: "Biology", color: "#FF6B57" },
  { name: "Math", color: "#FFC93C" },
  { name: "English", color: "#7C5CFF" },
  { name: "Computer", color: "#2E6F95" },
  { name: "Urdu", color: "#2FBF8F" },
  { name: "Pak Study", color: "#FF6B57" },
];

const features = [
  {
    title: "AI Tutor",
    desc: "Ask a question any time, day or night, and get a clear explanation built around what you're stuck on — not a generic answer.",
    icon: Brain,
    color: "#FF6B57",
    big: true,
  },
  {
    title: "Question Bank",
    desc: "Thousands of chapter-wise MCQs, sorted by topic and difficulty.",
    icon: Layers,
    color: "#2E6F95",
  },
  {
    title: "Timed Tests",
    desc: "Practice under real exam conditions with a live timer.",
    icon: Timer,
    color: "#FFC93C",
  },
  {
    title: "Revision Engine",
    desc: "We track what you keep getting wrong and bring it back until it sticks.",
    icon: Flame,
    color: "#2FBF8F",
  },
  {
    title: "Writing Practice",
    desc: "Get feedback on essays and short answers, not just a score.",
    icon: PenLine,
    color: "#7C5CFF",
  },
];

const steps = [
  {
    n: "01",
    title: "Pick your class & subjects",
    desc: "Tell us your grade and board once — everything after this is matched to you.",
  },
  {
    n: "02",
    title: "Practice & take tests",
    desc: "Work through MCQs, flashcards, and timed papers at your own pace.",
  },
  {
    n: "03",
    title: "Track your progress",
    desc: "See exactly which topics are strong and which need another look.",
  },
];

function Badge({ children, color }) {
  return (
    <span
      className="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-sm font-semibold"
      style={{ backgroundColor: `${color}1A`, color }}
    >
      {children}
    </span>
  );
}

function FloatingCard({ icon: Icon, label, color, className }) {
  return (
    <div
      className={`absolute flex items-center gap-2 rounded-2xl bg-white px-4 py-3 shadow-lg ${className}`}
      style={{ boxShadow: "0 12px 30px -10px rgba(11,37,69,0.25)" }}
    >
      <div
        className="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl"
        style={{ backgroundColor: `${color}1A` }}
      >
        <Icon size={18} color={color} />
      </div>
      <span className="text-sm font-bold" style={{ color: "#0B2545" }}>
        {label}
      </span>
    </div>
  );
}

export default function AspirianHomepage() {
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <div
      style={{ fontFamily: "Inter, sans-serif", color: "#0B2545" }}
      className="min-h-screen bg-white"
    >
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap');
        .font-display { font-family: 'Baloo 2', sans-serif; }
        @keyframes floatY {
          0%, 100% { transform: translateY(0px); }
          50% { transform: translateY(-10px); }
        }
        .float-slow { animation: floatY 6s ease-in-out infinite; }
        .float-slower { animation: floatY 7.5s ease-in-out infinite; animation-delay: 1s; }
        .float-slowest { animation: floatY 5s ease-in-out infinite; animation-delay: 2s; }
      `}</style>

      {/* NAV */}
      <header className="sticky top-0 z-30 border-b border-[#EAF1F8] bg-white/90 backdrop-blur">
        <div className="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
          <div className="flex items-center gap-2">
            <div
              className="flex h-9 w-9 items-center justify-center rounded-xl"
              style={{ backgroundColor: "#2E6F95" }}
            >
              <Sparkles size={18} color="white" />
            </div>
            <span className="font-display text-xl font-bold">Aspirian</span>
          </div>

          <nav className="hidden items-center gap-8 md:flex">
            {["Subjects", "AI Tutor", "Test Bank", "Pricing"].map((item) => (
              <a
                key={item}
                href="#"
                className="text-sm font-semibold text-[#0B2545]/70 transition hover:text-[#0B2545]"
              >
                {item}
              </a>
            ))}
          </nav>

          <div className="hidden items-center gap-3 md:flex">
            <a href="#" className="text-sm font-bold text-[#0B2545]">
              Log in
            </a>
            <a
              href="#"
              className="rounded-full px-5 py-2.5 text-sm font-bold text-white transition hover:opacity-90"
              style={{ backgroundColor: "#FF6B57" }}
            >
              Start free
            </a>
          </div>

          <button
            className="md:hidden"
            onClick={() => setMenuOpen(!menuOpen)}
            aria-label="Toggle menu"
          >
            {menuOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>

        {menuOpen && (
          <div className="border-t border-[#EAF1F8] px-6 py-4 md:hidden">
            {["Subjects", "AI Tutor", "Test Bank", "Pricing", "Log in"].map(
              (item) => (
                <a
                  key={item}
                  href="#"
                  className="block py-2 text-sm font-semibold text-[#0B2545]/80"
                >
                  {item}
                </a>
              )
            )}
            <a
              href="#"
              className="mt-2 block rounded-full px-5 py-2.5 text-center text-sm font-bold text-white"
              style={{ backgroundColor: "#FF6B57" }}
            >
              Start free
            </a>
          </div>
        )}
      </header>

      {/* HERO */}
      <section
        className="relative overflow-hidden px-6 pb-20 pt-16 md:pb-28 md:pt-20"
        style={{ backgroundColor: "#F7FAFD" }}
      >
        <div className="mx-auto grid max-w-6xl items-center gap-16 md:grid-cols-2">
          <div>
            <Badge color="#2E6F95">
              <Sparkles size={14} /> Built for Pakistani students
            </Badge>

            <h1 className="font-display mt-5 text-4xl font-extrabold leading-[1.1] md:text-5xl">
              Study smarter,
              <br />
              not just harder.
            </h1>

            <p className="mt-5 max-w-md text-lg leading-relaxed text-[#0B2545]/70">
              Practice MCQs, sit timed tests, and get an AI tutor that
              actually explains things — all matched to your class, board,
              and subjects.
            </p>

            <div className="mt-8 flex flex-wrap items-center gap-4">
              <a
                href="#"
                className="flex items-center gap-2 rounded-full px-7 py-3.5 text-base font-bold text-white shadow-lg transition hover:opacity-90"
                style={{
                  backgroundColor: "#FF6B57",
                  boxShadow: "0 12px 24px -8px rgba(255,107,87,0.5)",
                }}
              >
                Get started free <ArrowRight size={18} />
              </a>
              <a
                href="#"
                className="rounded-full px-7 py-3.5 text-base font-bold text-[#0B2545] transition hover:bg-[#EAF1F8]"
              >
                See how it works
              </a>
            </div>

            <div className="mt-10 flex items-center gap-6 text-sm text-[#0B2545]/60">
              <span className="flex items-center gap-1.5">
                <CheckCircle2 size={16} color="#2FBF8F" /> No credit card
              </span>
              <span className="flex items-center gap-1.5">
                <CheckCircle2 size={16} color="#2FBF8F" /> Free forever plan
              </span>
            </div>
          </div>

          <div className="relative hidden h-[420px] md:block">
            <div
              className="absolute left-6 top-0 flex h-64 w-64 items-center justify-center rounded-[2rem]"
              style={{ backgroundColor: "#2E6F95" }}
            >
              <BookOpen size={90} color="white" strokeWidth={1.5} />
            </div>
            <FloatingCard
              icon={Trophy}
              label="92% score"
              color="#FFC93C"
              className="float-slow -right-2 top-6"
            />
            <FloatingCard
              icon={Brain}
              label="AI Tutor online"
              color="#FF6B57"
              className="float-slower bottom-24 left-0"
            />
            <FloatingCard
              icon={Flame}
              label="12-day streak"
              color="#2FBF8F"
              className="float-slowest bottom-0 right-4"
            />
          </div>
        </div>
      </section>

      {/* SUBJECT STRIP */}
      <section className="border-y border-[#EAF1F8] bg-white py-6">
        <div className="mx-auto flex max-w-6xl flex-wrap items-center justify-center gap-3 px-6">
          {subjects.map((s) => (
            <span
              key={s.name}
              className="rounded-full border px-4 py-2 text-sm font-bold"
              style={{ borderColor: `${s.color}33`, color: s.color }}
            >
              {s.name}
            </span>
          ))}
        </div>
      </section>

      {/* FEATURES */}
      <section className="px-6 py-20 md:py-28">
        <div className="mx-auto max-w-6xl">
          <div className="max-w-xl">
            <h2 className="font-display text-3xl font-extrabold md:text-4xl">
              Everything you need, nothing you don't.
            </h2>
            <p className="mt-4 text-lg text-[#0B2545]/70">
              One platform for practice, testing, and revision — built around
              how students actually study.
            </p>
          </div>

          <div className="mt-12 grid gap-5 md:grid-cols-3">
            {features.map((f, i) => (
              <div
                key={f.title}
                className={`rounded-3xl p-7 ${
                  f.big ? "md:col-span-2 md:row-span-2" : ""
                }`}
                style={{ backgroundColor: `${f.color}12` }}
              >
                <div
                  className="flex h-12 w-12 items-center justify-center rounded-2xl"
                  style={{ backgroundColor: f.color }}
                >
                  <f.icon size={24} color="white" />
                </div>
                <h3 className="font-display mt-5 text-xl font-bold">
                  {f.title}
                </h3>
                <p className="mt-2 leading-relaxed text-[#0B2545]/70">
                  {f.desc}
                </p>
                {f.big && (
                  <div className="mt-6 flex items-center gap-2 text-sm font-bold" style={{ color: f.color }}>
                    Try the AI Tutor <ArrowRight size={16} />
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* HOW IT WORKS */}
      <section className="px-6 py-20" style={{ backgroundColor: "#0B2545" }}>
        <div className="mx-auto max-w-6xl">
          <h2 className="font-display text-3xl font-extrabold text-white md:text-4xl">
            Get started in three steps
          </h2>

          <div className="mt-12 grid gap-10 md:grid-cols-3">
            {steps.map((s) => (
              <div key={s.n}>
                <span
                  className="font-display text-4xl font-extrabold"
                  style={{ color: "#FFC93C" }}
                >
                  {s.n}
                </span>
                <h3 className="font-display mt-3 text-xl font-bold text-white">
                  {s.title}
                </h3>
                <p className="mt-2 leading-relaxed text-white/60">
                  {s.desc}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="px-6 py-20 md:py-28">
        <div
          className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-8 rounded-[2.5rem] px-8 py-14 text-center md:flex-row md:text-left"
          style={{ backgroundColor: "#EAF1F8" }}
        >
          <div>
            <h2 className="font-display text-3xl font-extrabold md:text-4xl">
              Ready to raise your score?
            </h2>
            <p className="mt-3 text-lg text-[#0B2545]/70">
              Join thousands of students already practicing on Aspirian.
            </p>
          </div>
          <a
            href="#"
            className="flex shrink-0 items-center gap-2 rounded-full px-8 py-4 text-base font-bold text-white shadow-lg transition hover:opacity-90"
            style={{ backgroundColor: "#FF6B57" }}
          >
            Start learning free <ArrowRight size={18} />
          </a>
        </div>
      </section>

      {/* FOOTER */}
      <footer className="border-t border-[#EAF1F8] px-6 py-10">
        <div className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 text-sm text-[#0B2545]/60 md:flex-row">
          <div className="flex items-center gap-2">
            <div
              className="flex h-7 w-7 items-center justify-center rounded-lg"
              style={{ backgroundColor: "#2E6F95" }}
            >
              <Sparkles size={14} color="white" />
            </div>
            <span className="font-display font-bold text-[#0B2545]">
              Aspirian
            </span>
          </div>
          <p>© 2026 Aspirian Student Platform. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
}