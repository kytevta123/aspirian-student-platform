import React from 'react';
import { createRoot } from 'react-dom/client';
import Home from './Pages/Home.jsx';

const container = document.getElementById('app');
if (container) {
  createRoot(container).render(<Home />);
}