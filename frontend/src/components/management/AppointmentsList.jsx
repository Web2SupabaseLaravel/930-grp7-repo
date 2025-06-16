import React, { useEffect, useState } from "react";
import "./AppointmentsList.css";

export default function AppointmentsList() {
  const [appointments, setAppointments] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost:8000/api/appointments") 
      .then((res) => res.json())
      .then((data) => {
          console.log("البيانات المستلمة:", data);
        setAppointments(data);
        setLoading(false);
      })
      .catch((error) => {
        console.error("حدث خطأ أثناء جلب البيانات:", error);
        setLoading(false);
      });
  }, []);

  return (
    <div className="appointments-container">
      <h2>جدول المواعيد</h2>
      {loading ? (
        <p>جاري التحميل...</p>
      ) : (
        <table className="appointments-table">
          <thead>
            <tr>
              <th>المريض</th>
              <th>الطبيب</th>
              <th>التاريخ</th>
              <th>الوقت</th>
              <th>الحالة</th>
            </tr>
          </thead>
                <tbody>
                  {appointments.map((apt) => (
                    <tr key={apt.id} className={`status-${apt.status?.replace(" ", "-").toLowerCase()}`}>
                      <td>{apt.patient?.name ?? "غير معروف"}</td>
                      <td>{apt.practitioner?.name ?? "غير معروف"}</td>
                      <td>{apt.appointment_date ?? "—"}</td>
                      <td>{apt.appointment_time ?? "—"}</td>
                      <td>{apt.status}</td>
                    </tr>
                  ))}
                </tbody>
        </table>
      )}
    </div>
  );
}
