import React from "react";

const AppointmentTable = ({ title, appointments, color }) => {
  return (
    <div className="mb-10">
      <h3 className={`text-${color}-600 font-bold mb-2 text-right`}>{title}</h3>
      <table className="w-full border text-right">
        <thead className="bg-gray-100">
          <tr>
            {appointments.length && appointments[0].status && <th className="border px-2">الحالة</th>}
            <th className="border px-2">الخدمة</th>
            <th className="border px-2">الطبيب</th>
            <th className="border px-2">الوقت</th>
            <th className="border px-2">التاريخ</th>
          </tr>
        </thead>
        <tbody>
          {appointments.map((a, index) => (
            <tr key={index}>
              {a.status && <td className="border px-2">{a.status}</td>}
              <td className="border px-2">{a.service}</td>
              <td className="border px-2">{a.doctor}</td>
              <td className="border px-2">{a.time}</td>
              <td className="border px-2">{a.date}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

const Appointments = ({ upcoming, past }) => {
  return (
    <div>
      <AppointmentTable title="المواعيد القادمة" appointments={upcoming} color="green" />
      <AppointmentTable title="المواعيد السابقة" appointments={past} color="red" />
    </div>
  );
};

export default Appointments;
