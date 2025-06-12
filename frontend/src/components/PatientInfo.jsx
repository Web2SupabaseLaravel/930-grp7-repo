import React from "react";

const PatientInfo = ({ patient, onEdit, onLogout }) => {
  return (
    <div className="text-center mb-10">
      <img
        src={patient.image || "https://via.placeholder.com/100"}
        alt="Patient"
        className="mx-auto rounded-full w-24 h-24 mb-4"
      />
      <h2 className="font-bold text-lg">مرحباً، المريض</h2>
      <p>
        البريد الإلكتروني: <strong>{patient.email}</strong>
      </p>
      <p>
        رقم الهاتف: <strong>{patient.phone}</strong>
      </p>
      <div className="mt-4 flex justify-center gap-4">
        <button onClick={onEdit} className="bg-blue-500 text-white px-4 py-2 rounded">
          تعديل المعلومات
        </button>
        <button onClick={onLogout} className="bg-red-500 text-white px-4 py-2 rounded">
          تسجيل الخروج
        </button>
      </div>
    </div>
  );
};

export default PatientInfo;
