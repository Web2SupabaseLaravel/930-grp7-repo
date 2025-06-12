import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './DoctorProfilePage.css';

export default function DoctorProfilePage() {
  const [profile, setProfile] = useState(null);
  const [appointments, setAppointments] = useState([]);
  const [loading, setLoading] = useState(true);
  const [editing, setEditing] = useState(false);
  const [form, setForm] = useState({});
  const token = localStorage.getItem('token');

  useEffect(() => {
    const fetchData = async () => {
      try {
        const profileRes = await axios.get('http://localhost:8000/api/profile', {
          headers: { Authorization: `Bearer ${token}` },
        });

        setProfile(profileRes.data.data);
        setForm(profileRes.data.data);

        const appointmentsRes = await axios.get('http://localhost:8000/api/practitioner/appointments', {
          headers: { Authorization: `Bearer ${token}` },
        });

        const upcoming = appointmentsRes.data.data.filter(app => app.status === 'upcoming');
        setAppointments(upcoming);
      } catch (error) {
        console.error('حدث خطأ في جلب البيانات:', error);
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  const handleEdit = () => setEditing(true);

  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSave = async () => {
    try {
      await axios.put('http://localhost:8000/api/practitioner/profile', form, {
        headers: { Authorization: `Bearer ${token}` },
      });
      setProfile(form);
      setEditing(false);
    } catch (error) {
      console.error('فشل حفظ التعديلات:', error);
    }
  };

  if (loading || !profile) return <div className="loading">جاري التحميل...</div>;

  return (
    <div className="doctor-container">
      <h2 className="header">الملف الشخصي للطبيب</h2>

      <div className="form-section">
        <label>الاسم:</label>
        <input type="text" name="name" value={form.name} onChange={handleChange} disabled={!editing} />

        <label>البريد الإلكتروني:</label>
        <input type="email" name="email" value={form.email} onChange={handleChange} disabled={!editing} />

        <label>رقم الهاتف:</label>
        <input type="text" name="phone" value={form.phone} onChange={handleChange} disabled={!editing} />

        <div className="buttons">
          {!editing ? (
            <button onClick={handleEdit}>تعديل المعلومات</button>
          ) : (
            <button onClick={handleSave}>حفظ التعديلات</button>
          )}
        </div>
      </div>

      <hr />

      <div className="appointments-section">
        <h3>المواعيد القادمة</h3>
        {appointments.length === 0 ? (
          <p>لا توجد مواعيد قادمة.</p>
        ) : (
          <table>
            <thead>
              <tr>
                <th>التاريخ</th>
                <th>الوقت</th>
                <th>المريض</th>
                <th>الخدمة</th>
              </tr>
            </thead>
            <tbody>
              {appointments.map((a, i) => (
                <tr key={i}>
                  <td>{a.date}</td>
                  <td>{a.time}</td>
                  <td>{a.patient}</td>
                  <td>{a.service}</td>
                </tr>
              ))}
            </tbody>
          </table>
        )}
      </div>
    </div>
  );
}
