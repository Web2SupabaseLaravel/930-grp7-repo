import React, { useEffect, useState } from 'react';
import axios from 'axios';
import PatientProfile from "../pages/PatientProfilePage";

const Dashboard = () => {
  const [patient, setPatient] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem('token');

    axios.get('http://127.0.0.1:8000/api/patient/profile', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
      withCredentials: true,
    })
      .then(response => {
        setPatient(response.data);
      })
      .catch(error => {
        console.error('خطأ في جلب البيانات', error);
      });
  }, []);

  return (
    <div className="min-h-screen bg-gray-50 p-8">
      <PatientProfile patient={patient} />
    </div>
  );
};

export default Dashboard;
