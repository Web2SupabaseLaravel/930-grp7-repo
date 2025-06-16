import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import { Container, Button, Box, Tabs, Tab, Typography } from '@mui/material';
import Header from './components/layout/Header.jsx';
import Footer from './components/layout/Footer.jsx';

import HealthcarePage from './components/layout/HealthcarePage.jsx';
import AppointmentPage from './components/pages/AppointmentPage.jsx';
import Login from './components/auth/login.jsx';
import Register from './components/auth/register.jsx';
import AdminDashboard from './components/DashboardPage.jsx';
import UserForm from './components/forms/UserForm';
import UserList from './components/management/UsersList.jsx';
import PractitionersForm from './components/forms/PractitionerForm';
import PractitionersList from './components/management/PractitionersList.jsx';
import AppointmentsList from './components/management/AppointmentsList.jsx';
import SettingsForm from './components/forms/SettingsForm.jsx';

function App() {
  return (
    <Router>
      <Routes>
        <Route
          path="/*"
          element={
            <>
              <Header />
              <Routes>
                <Route path="/" element={<HealthcarePage />} />
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="/AdminDashboard" element={<AdminDashboard />} />
                <Route path="/add-user" element={<UserForm/>} />
                <Route path="/users" element={<UserList />} />
                <Route path="/add-practitioner" element={<PractitionersForm/>} />
                <Route path="/practitioners" element={<PractitionersList/>} />
                <Route path="/appointments" element={<AppointmentsList />} />
                <Route path="/settings" element={<SettingsForm />} />
              </Routes>
              <Footer />
            </>
          }
        />
      </Routes>
    </Router>
  );
}

export default App;
