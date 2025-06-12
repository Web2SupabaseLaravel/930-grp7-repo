import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import PatientProfilePage from './pages/PatientProfilePage';
import DoctorProfilePage from './pages/DoctorProfilePage';
import EmployeeProfilePage from './pages/EmployeeProfilePage';



function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<PatientProfilePage />} />
        <Route path="/doctor/profile" element={<DoctorProfilePage />} />
       <Route path="/employee/profile" element={<EmployeeProfilePage />} />
         
      </Routes>
    </Router>
  );
}

export default App;
