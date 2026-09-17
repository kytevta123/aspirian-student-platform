import { useState } from "react";
import { Link, useLocation } from "react-router-dom";
import { Sparkles, Menu, X } from "lucide-react";

const C = {
  coral: "#F2453F",
  navy: "#0B2E35",
  ink: "#0B2545",
};

const navLinks = [
  { label: "Home", to: "/" },
  { label: "Subjects", to: "/#subjects" },
  { label: "AI Tutor", to: "/#ai-tutor" },
  { label: "Viva Practice", to: "/viva" },
  { label: "Test Bank", to: "/#tests" },
];

export default function Header() {
  const [menuOpen, setMenuOpen] = useState(false);
  const location = useLocation();

  return (
    <header className="sticky top-0 z-30 border-b" style={{ borderColor: "#0000000f", backgroundColor: "#FFFFFFE6", backdropFilter: "blur(6px)" }}>
      <div className="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <Link to="/" className="flex items-center gap-2">
          <div className="flex h-9 w-9 items-center justify-center rounded-xl" style={{ backgroundColor: C.coral }}>
            <Sparkles size={18} color="white" />
          </div>
          <span className="font-display text-xl font-bold" style={{ color: C.navy }}>Aspirian</span>
        </Link>

        <nav className="hidden items-center gap-8 md:flex">
          {navLinks.map((item) => (
            <Link
              key={item.label}
              to={item.to}
              className="text-sm font-semibold transition hover:opacity-70"
              style={{
                color: location.pathname === item.to ? C.coral : `${C.ink}B3`,
              }}
            >
              {item.label}
            </Link>
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
          {navLinks.map((item) => (
            <Link
              key={item.label}
              to={item.to}
              onClick={() => setMenuOpen(false)}
              className="block py-2 text-sm font-semibold"
              style={{ color: `${C.ink}CC` }}
            >
              {item.label}
            </Link>
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
  );
}