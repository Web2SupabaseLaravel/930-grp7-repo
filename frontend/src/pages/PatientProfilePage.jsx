import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './PatientProfilePage.css';

export default function PatientProfilePage() {
  const [profile, setProfile] = useState(null);
  const [appointments, setAppointments] = useState([]);
  const [loading, setLoading] = useState(true);

  const token = localStorage.getItem("token"); 

  useEffect(() => {
    const fetchData = async () => {
      try {
        const profileRes = await axios.get('http://localhost:8000/api/profile', { 

          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        setProfile(profileRes.data.data); 

        const appointmentsRes = await axios.get('http://127.0.0.1:8000/api/patient/appointments', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        setAppointments(appointmentsRes.data.data); 
      } catch (error) {
        console.error("خطأ أثناء جلب البيانات:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  if (loading || !profile) return <div className="loading">جار تحميل البيانات...</div>;

  const upcoming = appointments.filter(a => a.status === 'upcoming');
  const past = appointments.filter(a => a.status === 'done');

  return (
    <div className="patient-container">
      <div className="profile-section">
        <img src={profile.image} alt="صورة المريض" className="profile-image" />
        <h2>مرحباً، {profile.name}</h2>
        <p><strong>البريد الإلكتروني:</strong> {profile.email}</p>
        <p><strong>رقم الهاتف:</strong> {profile.phone}</p>
        <div className="button-group">
          <button className="edit-btn">تعديل المعلومات</button>
          <button className="logout-btn">تسجيل الخروج</button>
        </div>
      </div>

      <hr />

      <div className="appointments-section">
        <h3 className="section-title upcoming">المواعيد القادمة</h3>
        <table>
          <thead>
            <tr>
              <th>التاريخ</th>
              <th>الوقت</th>
              <th>الطبيب</th>
              <th>الخدمة</th>
            </tr>
          </thead>
          <tbody>
            {upcoming.map((item, index) => (
              <tr key={index}>
                <td>{item.date}</td>
                <td>{item.time}</td>
                <td>{item.doctor}</td>
                <td>{item.service}</td>
              </tr>
            ))}
          </tbody>
        </table>

        <h3 className="section-title past">المواعيد السابقة</h3>
        <table>
          <thead>
            <tr>
              <th>التاريخ</th>
              <th>الطبيب</th>
              <th>الخدمة</th>
              <th>الحالة</th>
            </tr>
          </thead>
          <tbody>
            {past.map((item, index) => (
              <tr key={index}>
                <td>{item.date}</td>
                <td>{item.doctor}</td>
                <td>{item.service}</td>
                <td>{item.status_ar}</td>
              </tr>
            ))}
          </tbody>
        </table>

        <button className="new-btn">حجز موعد جديد</button>
      </div>
    </div>
  );
}
