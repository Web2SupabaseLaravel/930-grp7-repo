import React, { useEffect, useState } from "react";
import "./PractitionersList.css";

export default function PractitionersList() {
  const [practitioners, setPractitioners] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost:8000/api/practitioners") 
      .then((response) => response.json())
      .then((data) => {
        setPractitioners(data);
        setLoading(false);
      })
      .catch((error) => {
        console.error("Error fetching practitioners:", error);
        setLoading(false);
      });
  }, []);

  return (
    <div className="practitioners-container">
      <h2>قائمة الأطباء والممارسين</h2>

      {loading ? (
        <p>جاري التحميل...</p>
      ) : (
        <table className="practitioners-table">
          <thead>
            <tr>
              <th>name</th>
              <th>Specialization</th>
              <th> Qualifications</th>
              <th>Contact</th>
              <th>Working Hours</th>
              <th>Services</th>
               <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {practitioners.map((practitioner) => (
              <tr key={practitioner.id}>
                <td>{practitioner.user?.name || 'بدون اسم'}</td>
                <td>{practitioner.specialization || 'N/A'}</td>
                <td>{practitioner.qualifications || 'N/A'}</td>
                <td>{practitioner.contact || 'N/A'}</td>
                <td>{practitioner.working_hours || 'N/A'}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}
