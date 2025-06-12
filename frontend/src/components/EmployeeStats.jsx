import React, { useEffect, useState } from 'react';
import './EmployeeStats.css';

function EmployeeStats() {
  const [stats, setStats] = useState({
    today: 0,
    confirmed: 0,
    canceled: 0
  });

  useEffect(() => {
    fetch('http://localhost:8000/api/employee/stats', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
      .then(res => res.json())
      .then(data => setStats(data));
  }, []);

  return (
    <div className="stats-container">
      <div className="stat-card purple">
        <span className="icon">📅</span>
        <h2>{stats.today}</h2>
        <p>مواعيد اليوم</p>
      </div>
      <div className="stat-card blue">
        <span className="icon">📋</span>
        <h2>{stats.confirmed}</h2>
        <p>مواعيد تم تأكيدها</p>
      </div>
      <div className="stat-card red">
        <span className="icon">❌</span>
        <h2>{stats.canceled}</h2>
        <p>مواعيد تم إلغاؤها</p>
      </div>
    </div>
  );
}

export default EmployeeStats;
