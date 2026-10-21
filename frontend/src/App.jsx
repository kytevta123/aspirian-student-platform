import { useEffect, useState } from 'react';
import { BrowserRouter, Routes, Route, Navigate, useLocation } from 'react-router-dom';
import { apiRequest } from './api';

import Login from './pages/Login.jsx';
import Register from './pages/Register.jsx';
import Home from './pages/Home.jsx';
import Viva from './pages/Viva.jsx';
import Practicals from './pages/Practicals.jsx';
import TeacherDashboard from './pages/TeacherDashboard.jsx';
import SchoolDashboard from './pages/SchoolDashboard.jsx';
import SchoolReports from './pages/SchoolReports.jsx';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/viva" element={<Viva />} />
        <Route path="/practicals" element={<Practicals />} />
        <Route path="/teacher" element={<TeacherDashboard />} />
        <Route path="/school" element={<SchoolDashboard />} />
        <Route
          path="/school/reports"
          element={
            <RequireAuth>
              <SchoolReports />
            </RequireAuth>
          }
        />
      </Routes>
    </BrowserRouter>
  );
}

function RequireAuth({ children }) {
  const location = useLocation();
  const [authState, setAuthState] = useState('checking');

  useEffect(() => {
    let active = true;

    Promise.resolve()
      .then(() => apiRequest('/user'))
      .then((response) => {
        if (active) {
          setAuthState(response.ok ? 'authenticated' : 'anonymous');
        }
      })
      .catch(() => {
        if (active) {
          setAuthState('anonymous');
        }
      });

    return () => {
      active = false;
    };
  }, []);

  if (authState === 'checking') {
    return (
      <main className="flex min-h-screen items-center justify-center bg-slate-950 text-sm text-slate-300" role="status">
        Checking your session...
      </main>
    );
  }

  if (authState === 'anonymous') {
    return (
      <Navigate
        to="/login"
        replace
        state={{ from: `${location.pathname}${location.search}` }}
      />
    );
  }

  return children;
}

export default App;