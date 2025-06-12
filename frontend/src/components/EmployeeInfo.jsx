import React, { useEffect, useState } from 'react';
import './EmployeeInfo.css';

function EmployeeInfo() {
  const [employee, setEmployee] = useState({});

  useEffect(() => {
    fetch('http://localhost:8000/api/profile', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
      .then(res => res.json())
      .then(data => setEmployee(data.data));
  }, []);

  return (
    <div className="info-container">
      <h2>المعلومات الشخصية</h2>
      <div className="info-grid">
        <div className="info-box"><strong>الاسم</strong><br />{employee.name}</div>
        <div className="info-box"><strong>الدور</strong><br />{employee.role}</div>
        <div className="info-box"><strong>البريد الإلكتروني</strong><br />{employee.email}</div>
        <div className="info-box"><strong>رقم الهاتف</strong><br />{employee.phone_number}</div>
        <div className="info-box"><strong>أوقات العمل</strong><br />{employee.working_hours}</div>
      </div>
      <button className="edit-btn">تغيير المعلومات</button>
    </div>
  );
}

export default EmployeeInfo;
