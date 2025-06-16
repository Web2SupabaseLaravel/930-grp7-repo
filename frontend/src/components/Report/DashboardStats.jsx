import React, { useState, useEffect } from "react";
import axios from "axios";
 import "./DashboardStats.css";

const DashboardStats = () => {
  const [stats, setStats] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/dashboard-stats")
        .then((response) => {
        let data = response.data;
        if (typeof data === "string") {
            data = JSON.parse(data); 
        }
        setStats(data);
        setLoading(false);
        })
      .catch((error) => {
        console.error("خطأ في جلب البيانات:", error);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <p>جاري تحميل البيانات...</p>;
  }

  if (!stats) {
    return <p>لم يتم تحميل البيانات.</p>;
  }

  return (
    <div className="dashboard">
      <h2>لوحة التحكم - المشرف</h2>
      <div className="cards-container">
        <div className="card">
          <h3>إجمالي المستخدمين</h3>
          <p>{stats.users}</p>
        </div>
        <div className="card">
          <h3>الممارسون</h3>
          <p>{stats.practitioners}</p>
        </div>
        <div className="card">
          <h3>الخدمات</h3>
          <p>{stats.services}</p>
        </div>
        <div className="card">
          <h3>المواعيد</h3>
          <p>{stats.appointments}</p>
        </div>
        <div className="card">
          <h3>عدد المواعيد التي تم حجزها اليوم</h3>
          <p>{stats.todayAppointments}</p>
        </div>
      </div>
    </div>
  );
};

export default DashboardStats;
