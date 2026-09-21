import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from './pages/Home.jsx';
import Viva from './pages/Viva.jsx';
import Practicals from './pages/Practicals.jsx';
import TeacherDashboard from './pages/TeacherDashboard.jsx';
import SchoolDashboard from './pages/SchoolDashboard.jsx';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/viva" element={<Viva />} />
        <Route path="/practicals" element={<Practicals />} />
        <Route path="/teacher" element={<TeacherDashboard />} />
        <Route path="/school" element={<SchoolDashboard />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;