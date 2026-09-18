import { Link } from "react-router-dom";
import { Sparkles } from "lucide-react";

const C = {
  coral: "#F2453F",
  navyDark: "#071B24",
};

export default function Footer() {
  return (
    <footer className="px-6 py-10" style={{ backgroundColor: C.navyDark }}>
      <div className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 text-sm text-white/50 md:flex-row">
        <div className="flex items-center gap-2">
          <div className="flex h-7 w-7 items-center justify-center rounded-lg" style={{ backgroundColor: C.coral }}>
            <Sparkles size={14} color="white" />
          </div>
          <span className="font-display font-bold text-white">Aspirian</span>
        </div>

        <nav className="flex flex-wrap items-center justify-center gap-4">
          <Link to="/" className="hover:text-white">Home</Link>
          <Link to="/viva" className="hover:text-white">Viva Practice</Link>
          <Link to="/practicals" className="hover:text-white">Practicals</Link>
          <a href="#" className="hover:text-white">Privacy Policy</a>
          <a href="#" className="hover:text-white">Terms</a>
        </nav>

        <p>© 2026 Aspirian Student Platform. All rights reserved.</p>
      </div>
    </footer>
  );
}