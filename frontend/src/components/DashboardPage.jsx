import React, { useState } from 'react';
import Header from './layout/Header';
import Sidebar from './layout/Sidebar';
import DashboardStats from './Report/DashboardStats';
import CancellationNoShowStats from './Report/CancellationNoShowChart';
import AppointmentVolumeChart from './Report/AppointmentVolumeChart';
import TopBusyDaysChart from './Report/TopBusyPeriods';
import TopActiveDoctorsChart from './Report/TopActiveDoctorsChart';
import PractitionerReportCard from './Report/DailyAppointmentsCard';

import './AdminDashboard.css';
import './layout/Sidebar.css';

export default function AdminDashboard() {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const toggleSidebar = () => setSidebarOpen(open => !open);

  return (
    <div className="admin-dashboard-container">
     
      {sidebarOpen && <div className="overlay" onClick={toggleSidebar} />}
      <button
        className="toggle-btn"
        onClick={toggleSidebar}
        aria-label="فتح القائمة"
      >
        <div className={`hamburger-icon ${sidebarOpen ? 'open' : ''}`}>
          <span /><span /><span />
        </div>
      </button>


      <Sidebar isOpen={sidebarOpen} toggleSidebar={toggleSidebar} />

      <div className="admin-dashboard">


        <div className="stats-grid">
          <DashboardStats />
        </div>

        <div className="main-cancel-chart">
          <div className="chart-card">
            <CancellationNoShowStats />
          </div>
        </div>

        <div className="charts-grid">
          <div className="chart-card">
            <TopBusyDaysChart />
          </div>
          <div className="chart-card">
            <TopActiveDoctorsChart />
          </div>
          <div className="chart-card">
            <AppointmentVolumeChart />
          </div>
        </div>

        <div className="daily-appointments-section">
          <PractitionerReportCard />
        </div>
      </div>
    </div>
  );
}
