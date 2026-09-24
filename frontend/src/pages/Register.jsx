import { useState } from "react";
import { Link } from "react-router-dom";

function Register() {
  const [form, setForm] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  const handleChange = (event) => {
    const { name, value } = event.target;

    setForm((current) => ({
      ...current,
      [name]: value,
    }));

    if (error) {
      setError("");
    }
  };

  const passwordChecks = {
    length: form.password.length >= 8,
    uppercase: /[A-Z]/.test(form.password),
    lowercase: /[a-z]/.test(form.password),
    number: /[0-9]/.test(form.password),
  };

  const passwordScore = Object.values(passwordChecks).filter(Boolean).length;

  let passwordStrength = "";

  if (passwordScore > 0 && passwordScore <= 2) {
    passwordStrength = "Weak";
  } else if (passwordScore === 3) {
    passwordStrength = "Good";
  } else if (passwordScore === 4) {
    passwordStrength = "Strong";
  }

  const handleSubmit = async (event) => {
    event.preventDefault();

    setError("");

    if (form.password !== form.password_confirmation) {
      setError("Passwords do not match.");
      return;
    }

    if (passwordScore < 3) {
      setError(
        "Please choose a stronger password with uppercase, lowercase and a number."
      );
      return;
    }

    setLoading(true);

    // Temporary UI test only.
    // Laravel registration will be connected in the next step.
    await new Promise((resolve) => setTimeout(resolve, 700));

    setLoading(false);

    // Temporary navigation for UI testing.
    // This will be replaced with the real registration flow.
  };

  return (
    <main className="relative min-h-screen overflow-hidden bg-slate-950 text-white">
      {/* Animated Background */}
      <div className="pointer-events-none absolute inset-0 overflow-hidden">
        <div className="absolute -left-32 -top-32 h-96 w-96 animate-pulse rounded-full bg-cyan-500/20 blur-3xl" />

        <div
          className="absolute -bottom-40 -right-32 h-[28rem] w-[28rem] animate-pulse rounded-full bg-blue-600/20 blur-3xl"
          style={{ animationDelay: "1.5s" }}
        />

        <div
          className="absolute left-1/2 top-1/3 h-72 w-72 -translate-x-1/2 rounded-full bg-indigo-500/10 blur-3xl"
          style={{ animation: "float 8s ease-in-out infinite" }}
        />

        {/* Grid */}
        <div className="absolute inset-0 opacity-[0.07] [background-image:linear-gradient(rgba(255,255,255,.5)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.5)_1px,transparent_1px)] [background-size:50px_50px]" />

        {/* Floating Particles */}
        <span
          className="absolute left-[10%] top-[25%] h-2 w-2 animate-ping rounded-full bg-cyan-300"
          style={{ animationDuration: "3s" }}
        />

        <span
          className="absolute right-[17%] top-[32%] h-1.5 w-1.5 animate-ping rounded-full bg-blue-300"
          style={{ animationDuration: "4s" }}
        />

        <span
          className="absolute bottom-[27%] left-[22%] h-1.5 w-1.5 animate-ping rounded-full bg-indigo-300"
          style={{ animationDuration: "3.5s" }}
        />

        <span
          className="absolute bottom-[15%] right-[28%] h-2 w-2 animate-ping rounded-full bg-cyan-200"
          style={{ animationDuration: "5s" }}
        />
      </div>

      {/* Top Right ASPIRIAN */}
      <div className="absolute right-5 top-5 z-20 sm:right-8 sm:top-8">
        <div className="select-none text-right">
          <div className="animate-[float_5s_ease-in-out_infinite] text-2xl font-black tracking-[0.25em] text-cyan-300 drop-shadow-[0_0_15px_rgba(103,232,249,0.5)] sm:text-3xl">
            ASPIRIAN
          </div>

          <div className="mt-1 text-[9px] font-medium uppercase tracking-[0.35em] text-slate-400">
            Learn • Grow • Achieve
          </div>
        </div>
      </div>

      {/* Bottom Left ASPIRIAN */}
      <div className="absolute bottom-5 left-5 z-20 sm:bottom-8 sm:left-8">
        <div className="select-none">
          <div className="animate-[floatReverse_6s_ease-in-out_infinite] text-2xl font-black tracking-[0.2em] text-blue-300/90 drop-shadow-[0_0_15px_rgba(147,197,253,0.35)] sm:text-3xl">
            ASPIRIAN
          </div>

          <div className="mt-1 text-[9px] font-medium uppercase tracking-[0.3em] text-slate-500">
            Student Platform
          </div>
        </div>
      </div>

      {/* Main Content */}
      <div className="relative z-10 flex min-h-screen items-center justify-center px-4 py-16">
        <div className="w-full max-w-md">

          {/* Brand */}
          <div className="mb-6 text-center">
            <div className="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl border border-cyan-300/20 bg-cyan-400/10 shadow-[0_0_40px_rgba(34,211,238,0.12)] backdrop-blur-xl">
              <svg
                viewBox="0 0 24 24"
                className="h-7 w-7 text-cyan-300"
                fill="none"
                stroke="currentColor"
                strokeWidth="1.7"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M12 3 3.5 7.5 12 12l8.5-4.5L12 3Z"
                />

                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M6.5 10.2V15c0 1.8 2.46 3.5 5.5 3.5s5.5-1.7 5.5-3.5v-4.8"
                />

                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M20.5 8v5"
                />
              </svg>
            </div>

            <h1 className="text-3xl font-extrabold tracking-tight">
              Create Account
            </h1>

            <p className="mt-2 text-sm text-slate-400">
              Start your learning journey with Aspirian
            </p>
          </div>

          {/* Register Card */}
          <div className="relative overflow-hidden rounded-3xl border border-white/10 bg-white/[0.07] p-6 shadow-2xl shadow-black/40 backdrop-blur-2xl sm:p-8">

            <div className="pointer-events-none absolute -right-20 -top-20 h-40 w-40 rounded-full bg-cyan-400/10 blur-3xl" />

            <form onSubmit={handleSubmit} className="relative space-y-4">

              {/* Error */}
              {error && (
                <div className="flex items-start gap-3 rounded-xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                  <svg
                    className="mt-0.5 h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                  >
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 8v5" />
                    <path d="M12 16h.01" />
                  </svg>

                  <span>{error}</span>
                </div>
              )}

              {/* Full Name */}
              <div>
                <label
                  htmlFor="name"
                  className="mb-2 block text-sm font-medium text-slate-200"
                >
                  Full Name
                </label>

                <div className="relative">
                  <svg
                    className="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.8"
                  >
                    <circle cx="12" cy="8" r="3.5" />
                    <path d="M5 20c.8-3.2 3.1-5 7-5s6.2 1.8 7 5" />
                  </svg>

                  <input
                    id="name"
                    name="name"
                    type="text"
                    value={form.name}
                    onChange={handleChange}
                    placeholder="Your full name"
                    autoComplete="name"
                    required
                    className="w-full rounded-xl border border-white/10 bg-black/20 py-3.5 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-300/50 focus:bg-white/[0.08] focus:ring-2 focus:ring-cyan-300/10"
                  />
                </div>
              </div>

              {/* Email */}
              <div>
                <label
                  htmlFor="email"
                  className="mb-2 block text-sm font-medium text-slate-200"
                >
                  Email Address
                </label>

                <div className="relative">
                  <svg
                    className="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.8"
                  >
                    <rect
                      x="3"
                      y="5"
                      width="18"
                      height="14"
                      rx="2"
                    />

                    <path d="m3 7 9 6 9-6" />
                  </svg>

                  <input
                    id="email"
                    name="email"
                    type="email"
                    value={form.email}
                    onChange={handleChange}
                    placeholder="you@example.com"
                    autoComplete="email"
                    required
                    className="w-full rounded-xl border border-white/10 bg-black/20 py-3.5 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-300/50 focus:bg-white/[0.08] focus:ring-2 focus:ring-cyan-300/10"
                  />
                </div>
              </div>

              {/* Password */}
              <div>
                <label
                  htmlFor="password"
                  className="mb-2 block text-sm font-medium text-slate-200"
                >
                  Password
                </label>

                <div className="relative">
                  <svg
                    className="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.8"
                  >
                    <rect
                      x="4"
                      y="10"
                      width="16"
                      height="10"
                      rx="2"
                    />

                    <path
                      d="M8 10V7a4 4 0 0 1 8 0v3"
                      strokeLinecap="round"
                    />
                  </svg>

                  <input
                    id="password"
                    name="password"
                    type={showPassword ? "text" : "password"}
                    value={form.password}
                    onChange={handleChange}
                    placeholder="Create a password"
                    autoComplete="new-password"
                    required
                    className="w-full rounded-xl border border-white/10 bg-black/20 py-3.5 pl-12 pr-12 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-300/50 focus:bg-white/[0.08] focus:ring-2 focus:ring-cyan-300/10"
                  />

                  <button
                    type="button"
                    onClick={() => setShowPassword((current) => !current)}
                    aria-label={
                      showPassword ? "Hide password" : "Show password"
                    }
                    className="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-500 transition hover:text-cyan-300"
                  >
                    {showPassword ? (
                      <svg
                        className="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="1.8"
                      >
                        <path d="M3 3l18 18" />
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8" />
                        <path d="M9.9 4.2A10.8 10.8 0 0 1 12 4c5 0 8.5 4 9.5 6-.4.8-1.3 2.2-2.8 3.5" />
                        <path d="M6.6 6.6C4.5 7.9 3.2 9.7 2.5 10c1 2 4.5 6 9.5 6 1 0 2-.2 2.8-.5" />
                      </svg>
                    ) : (
                      <svg
                        className="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="1.8"
                      >
                        <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" />
                        <circle cx="12" cy="12" r="2.5" />
                      </svg>
                    )}
                  </button>
                </div>

                {/* Password Strength */}
                {form.password && (
                  <div className="mt-3">
                    <div className="mb-2 flex items-center justify-between">
                      <span className="text-[11px] text-slate-500">
                        Password strength
                      </span>

                      <span
                        className={`text-[11px] font-semibold ${
                          passwordStrength === "Strong"
                            ? "text-emerald-300"
                            : passwordStrength === "Good"
                              ? "text-cyan-300"
                              : "text-amber-300"
                        }`}
                      >
                        {passwordStrength}
                      </span>
                    </div>

                    <div className="flex gap-1">
                      {[1, 2, 3, 4].map((level) => (
                        <div
                          key={level}
                          className={`h-1 flex-1 rounded-full ${
                            level <= passwordScore
                              ? "bg-cyan-400"
                              : "bg-white/10"
                          }`}
                        />
                      ))}
                    </div>
                  </div>
                )}
              </div>

              {/* Confirm Password */}
              <div>
                <label
                  htmlFor="password_confirmation"
                  className="mb-2 block text-sm font-medium text-slate-200"
                >
                  Confirm Password
                </label>

                <div className="relative">
                  <svg
                    className="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.8"
                  >
                    <path
                      d="M5 12.5 9.2 17 19 7"
                      strokeLinecap="round"
                      strokeLinejoin="round"
                    />
                  </svg>

                  <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type={showConfirmPassword ? "text" : "password"}
                    value={form.password_confirmation}
                    onChange={handleChange}
                    placeholder="Confirm your password"
                    autoComplete="new-password"
                    required
                    className="w-full rounded-xl border border-white/10 bg-black/20 py-3.5 pl-12 pr-12 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-300/50 focus:bg-white/[0.08] focus:ring-2 focus:ring-cyan-300/10"
                  />

                  <button
                    type="button"
                    onClick={() =>
                      setShowConfirmPassword((current) => !current)
                    }
                    aria-label={
                      showConfirmPassword
                        ? "Hide password"
                        : "Show password"
                    }
                    className="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-500 transition hover:text-cyan-300"
                  >
                    {showConfirmPassword ? (
                      <svg
                        className="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="1.8"
                      >
                        <path d="M3 3l18 18" />
                        <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8" />
                        <path d="M9.9 4.2A10.8 10.8 0 0 1 12 4c5 0 8.5 4 9.5 6-.4.8-1.3 2.2-2.8 3.5" />
                        <path d="M6.6 6.6C4.5 7.9 3.2 9.7 2.5 10c1 2 4.5 6 9.5 6 1 0 2-.2 2.8-.5" />
                      </svg>
                    ) : (
                      <svg
                        className="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="1.8"
                      >
                        <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" />
                        <circle cx="12" cy="12" r="2.5" />
                      </svg>
                    )}
                  </button>
                </div>
              </div>

              {/* Terms */}
              <label className="flex cursor-pointer items-start gap-3 pt-1">
                <input
                  type="checkbox"
                  required
                  className="mt-0.5 h-4 w-4 rounded border-white/20 bg-white/10 accent-cyan-400"
                />

                <span className="text-xs leading-5 text-slate-400">
                  I agree to Aspirian's{" "}
                  <span className="text-cyan-300">Terms of Service</span>{" "}
                  and{" "}
                  <span className="text-cyan-300">Privacy Policy</span>.
                </span>
              </label>

              {/* Create Account */}
              <button
                type="submit"
                disabled={loading}
                className="group relative mt-1 flex w-full items-center justify-center overflow-hidden rounded-xl bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-500 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-900/30 transition duration-300 hover:scale-[1.01] hover:shadow-cyan-500/20 disabled:cursor-not-allowed disabled:opacity-60"
              >
                <span className="absolute inset-0 -translate-x-full bg-white/20 transition-transform duration-700 group-hover:translate-x-full" />

                {loading ? (
                  <span className="relative flex items-center gap-2">
                    <span className="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white" />
                    Creating account...
                  </span>
                ) : (
                  <span className="relative flex items-center gap-2">
                    Create Account

                    <svg
                      className="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      strokeWidth="2"
                    >
                      <path d="M5 12h14" />
                      <path d="m13 6 6 6-6 6" />
                    </svg>
                  </span>
                )}
              </button>
            </form>

            {/* Login Link */}
            <div className="mt-6 flex items-center justify-center gap-2 text-sm">
              <span className="text-slate-500">
                Already have an account?
              </span>

              <Link
                to="/login"
                className="font-semibold text-cyan-300 transition hover:text-cyan-200"
              >
                Sign In
              </Link>
            </div>
          </div>

          {/* Footer */}
          <p className="mt-5 text-center text-xs text-slate-600">
            Aspirian Student Platform • Learn • Grow • Achieve
          </p>
        </div>
      </div>

      {/* Local Animations */}
      <style>{`
        @keyframes float {
          0%, 100% {
            transform: translate(-50%, 0);
          }

          50% {
            transform: translate(-50%, -20px);
          }
        }

        @keyframes floatReverse {
          0%, 100% {
            transform: translate(0, 0);
          }

          50% {
            transform: translate(12px, -12px);
          }
        }
      `}</style>
    </main>
  );
}

export default Register;