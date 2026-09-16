import { useState } from "react";
import {
  Sparkles,
  BookOpen,
  Brain,
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

// ===== Aspirian Brand Palette (from aspirian.pk) =====
const C = {
  navyDark: "#071B24",
  navy: "#0B2E35",
  teal: "#0F6E6B",
  coral: "#F2453F", // primary CTA
  green: "#17D67D", // accent circles / highlights
  orange: "#FF9F1C", // highlighted subheadings
  white: "#FFFFFF",
  ink: "#0B2545", // body text on light sections
};

const subjects = [
  { name: "Physics", color: C.teal },
  { name: "Chemistry", color: C.green },
  { name: "Biology", color: C.coral },
  { name: "Math", color: C.orange },
  { name: "English", color: C.teal },
  { name: "Computer", color: C.green },
  { name: "Urdu", color: C.coral },
  { name: "Pak Study", color: C.orange },
];

const features = [
  {
    title: "AI Tutor",
    desc: "Ask a question any time, day or night, and get a clear explanation built around what you're stuck on — not a generic answer.",
    icon: Brain,
    color: C.coral,
    big: true,
  },
  {
    title: "Question Bank",
    desc: "Thousands of chapter-wise MCQs, sorted by topic and difficulty.",
    icon: Layers,
    color: C.teal,
  },
  {
    title: "Timed Tests",
    desc: "Practice under real exam conditions with a live timer.",
    icon: Timer,
    color: C.orange,
  },
  {
    title: "Revision Engine",
    desc: "We track what you keep getting wrong and bring it back until it sticks.",
    icon: Flame,
    color: C.green,
  },
  {
    title: "Writing Practice",
    desc: "Get feedback on essays and short answers, not just a score.",
    icon: PenLine,
    color: C.teal,
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
      style={{ backgroundColor: `${color}20`, color }}
    >
      {children}
    </span>
  );
}

function FloatingCard({ icon: Icon, label, color, className }) {
  return (
    <div
      className={`absolute flex items-center gap-2 rounded-2xl bg-white px-4 py-3 shadow-lg ${className}`}
      style={{ boxShadow: "0 12px 30px -10px rgba(7,27,36,0.35)" }}
    >
      <div
        className="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl"
        style={{ backgroundColor: `${color}20` }}
      >
        <Icon size={18} color={color} />
      </div>
      <span className="text-sm font-bold" style={{ color: C.ink }}>
        {label}
      </span>
    </div>
  );
}

export default function AspirianHomepage() {
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <div style={{ fontFamily: "Inter, sans-serif", color: C.ink }} className="min-h-screen bg-white">
      <style>{`
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap');
        .font-display { font-family: 'Baloo 2', sans-serif; }
        @keyframes floatY { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        .float-slow { animation: floatY 6s ease-in-out infinite; }
        .float-slower { animation: floatY 7.5s ease-in-out infinite; animation-delay: 1s; }
        .float-slowest { animation: floatY 5s ease-in-out infinite; animation-delay: 2s; }
      `}</style>

      {/* NAV */}
      <header className="sticky top-0 z-30 border-b" style={{ borderColor: "#0000000f", backgroundColor: `${C.white}E6` }}>
        <div className="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
          <div className="flex items-center gap-2">
            <div className="flex h-9 w-9 items-center justify-center rounded-xl" style={{ backgroundColor: C.coral }}>
              <Sparkles size={18} color="white" />
            </div>
            <span className="font-display text-xl font-bold" style={{ color: C.navy }}>Aspirian</span>
          </div>

          <nav className="hidden items-center gap-8 md:flex">
            {["Subjects", "AI Tutor", "Test Bank", "Pricing"].map((item) => (
              <a key={item} href="#" className="text-sm font-semibold transition" style={{ color: `${C.ink}B3` }}>
                {item}
              </a>
            ))}
          </nav>

          <div className="hidden items-center gap-3 md:flex">
            <a href="#" className="text-sm font-bold" style={{ color: C.navy }}>Log in</a>
            <a
              href="#"
              className="rounded-full px-5 py-2.5 text-sm font-bold text-white transition hover:opacity-90"
              style={{ backgroundColor: C.coral }}
            >
              Start free
            </a>
          </div>

          <button className="md:hidden" onClick={() => setMenuOpen(!menuOpen)} aria-label="Toggle menu">
            {menuOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>

        {menuOpen && (
          <div className="border-t px-6 py-4 md:hidden" style={{ borderColor: "#0000000f" }}>
            {["Subjects", "AI Tutor", "Test Bank", "Pricing", "Log in"].map((item) => (
              <a key={item} href="#" className="block py-2 text-sm font-semibold" style={{ color: `${C.ink}CC` }}>
                {item}
              </a>
            ))}
            <a
              href="#"
              className="mt-2 block rounded-full px-5 py-2.5 text-center text-sm font-bold text-white"
              style={{ backgroundColor: C.coral }}
            >
              Start free
            </a>
          </div>
        )}
      </header>

      {/* HERO */}
      <section
        className="relative overflow-hidden px-6 pb-20 pt-16 md:pb-28 md:pt-20"
        style={{ background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 45%, ${C.teal} 100%)` }}
      >
        <div className="mx-auto grid max-w-6xl items-center gap-16 md:grid-cols-2">
          <div>
            <Badge color={C.green}>
              <Sparkles size={14} /> Built for Pakistani students
            </Badge>

            <h1 className="font-display mt-5 text-4xl font-extrabold leading-[1.1] text-white md:text-5xl">
              Welcome to Aspirian
            </h1>
            <p className="font-display mt-2 text-2xl font-bold md:text-3xl" style={{ color: C.orange }}>
              The Future of Students Begins Here
            </p>

            <p className="mt-5 max-w-md text-lg leading-relaxed text-white/80">
              Practice MCQs, sit timed tests, and get an AI tutor that
              actually explains things — all matched to your class, board,
              and subjects.
            </p>

            <div className="mt-8 flex flex-wrap items-center gap-4">
              <a
                href="#"
                className="flex items-center gap-2 rounded-full px-7 py-3.5 text-base font-bold text-white shadow-lg transition hover:opacity-90"
                style={{ backgroundColor: C.coral, boxShadow: `0 12px 24px -8px ${C.coral}80` }}
              >
                Start Learning <ArrowRight size={18} />
              </a>
              <a
                href="#"
                className="rounded-full border-2 px-7 py-3.5 text-base font-bold text-white transition hover:bg-white/10"
                style={{ borderColor: "#ffffff40" }}
              >
                Study Notes
              </a>
            </div>

            <div className="mt-10 flex items-center gap-6 text-sm text-white/60">
              <span className="flex items-center gap-1.5">
                <CheckCircle2 size={16} color={C.green} /> No credit card
              </span>
              <span className="flex items-center gap-1.5">
                <CheckCircle2 size={16} color={C.green} /> Free forever plan
              </span>
            </div>
          </div>

          <div className="relative hidden h-[420px] md:block">
            <div
              className="absolute left-6 top-0 flex h-64 w-64 items-center justify-center rounded-[2rem]"
              style={{ backgroundColor: `${C.white}14`, border: `2px solid ${C.green}40` }}
            >
              <BookOpen size={90} color={C.green} strokeWidth={1.5} />
            </div>
            <FloatingCard icon={Trophy} label="92% score" color={C.orange} className="float-slow -right-2 top-6" />
            <FloatingCard icon={Brain} label="AI Tutor online" color={C.coral} className="float-slower bottom-24 left-0" />
            <FloatingCard icon={Flame} label="12-day streak" color={C.green} className="float-slowest bottom-0 right-4" />
          </div>
        </div>
      </section>

      {/* SUBJECT STRIP */}
      <section className="border-y bg-white py-6" style={{ borderColor: "#0000000f" }}>
        <div className="mx-auto flex max-w-6xl flex-wrap items-center justify-center gap-3 px-6">
          {subjects.map((s) => (
            <span
              key={s.name}
              className="rounded-full border px-4 py-2 text-sm font-bold"
              style={{ borderColor: `${s.color}40`, color: s.color }}
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
            <h2 className="font-display text-3xl font-extrabold md:text-4xl" style={{ color: C.navy }}>
              Everything you need, nothing you don't.
            </h2>
            <p className="mt-4 text-lg" style={{ color: `${C.ink}B3` }}>
              One platform for practice, testing, and revision — built around
              how students actually study.
            </p>
          </div>

          <div className="mt-12 grid gap-5 md:grid-cols-3">
            {features.map((f) => (
              <div
                key={f.title}
                className={`rounded-3xl p-7 ${f.big ? "md:col-span-2 md:row-span-2" : ""}`}
                style={{ backgroundColor: `${f.color}0F` }}
              >
                <div className="flex h-12 w-12 items-center justify-center rounded-2xl" style={{ backgroundColor: f.color }}>
                  <f.icon size={24} color="white" />
                </div>
                <h3 className="font-display mt-5 text-xl font-bold" style={{ color: C.navy }}>{f.title}</h3>
                <p className="mt-2 leading-relaxed" style={{ color: `${C.ink}B3` }}>{f.desc}</p>
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
      <section className="px-6 py-20" style={{ background: `linear-gradient(115deg, ${C.navyDark} 0%, ${C.navy} 100%)` }}>
        <div className="mx-auto max-w-6xl">
          <h2 className="font-display text-3xl font-extrabold text-white md:text-4xl">
            Get started in three steps
          </h2>

          <div className="mt-12 grid gap-10 md:grid-cols-3">
            {steps.map((s) => (
              <div key={s.n}>
                <span className="font-display text-4xl font-extrabold" style={{ color: C.orange }}>{s.n}</span>
                <h3 className="font-display mt-3 text-xl font-bold text-white">{s.title}</h3>
                <p className="mt-2 leading-relaxed text-white/60">{s.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="px-6 py-20 md:py-28">
        <div
          className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-8 rounded-[2.5rem] px-8 py-14 text-center md:flex-row md:text-left"
          style={{ backgroundColor: `${C.teal}14` }}
        >
          <div>
            <h2 className="font-display text-3xl font-extrabold md:text-4xl" style={{ color: C.navy }}>
              Ready to raise your score?
            </h2>
            <p className="mt-3 text-lg" style={{ color: `${C.ink}B3` }}>
              Join thousands of students already practicing on Aspirian.
            </p>
          </div>
          <a
            href="#"
            className="flex shrink-0 items-center gap-2 rounded-full px-8 py-4 text-base font-bold text-white shadow-lg transition hover:opacity-90"
            style={{ backgroundColor: C.coral }}
          >
            Start learning free <ArrowRight size={18} />
          </a>
        </div>
      </section>

      {/* FOOTER */}
      <footer className="px-6 py-10" style={{ backgroundColor: C.navyDark }}>
        <div className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 text-sm text-white/50 md:flex-row">
          <div className="flex items-center gap-2">
            <div className="flex h-7 w-7 items-center justify-center rounded-lg" style={{ backgroundColor: C.coral }}>
              <Sparkles size={14} color="white" />
            </div>
            <span className="font-display font-bold text-white">Aspirian</span>
          </div>
          <p>© 2026 Aspirian Student Platform. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
}