import { useState, useEffect } from "react";
import api from "../../../api"; 
import "./BookAppointment.css";

const BookAppointment = () => {
  const [services, setServices] = useState([]);
  const [doctors, setDoctors] = useState([]);
  const [form, setForm] = useState({
    service_id: "",
    practitioner_id: "",
    appointment_date: "",
    appointment_time: "",
    status: "scheduled",
    patient_id: 6, // مؤقتا لاني ما ربطتها مية بالمية 
  });
  const [message, setMessage] = useState("");

 
  useEffect(() => {
    api.get("/services")
      .then((res) => {
        setServices(res.data);
      })
      .catch((err) => {
        console.error("faill loading Services", err);
      });
  }, []);

  const handleServiceChange = async (e) => {
    const selectedServiceId = e.target.value;
    setForm({ ...form, service_id: selectedServiceId, practitioner_id: "" });

    try {
      const res = await api.get(`/services/${selectedServiceId}`);
      setDoctors(res.data.practitioners || []);
    } catch (err) {
      console.error("faill getting doctors", err);
      setDoctors([]);
    }
  };

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleBook = () => {
    api.post("/appointments", form)
      .then(() => setMessage("تم الحجز بنجاح "))
      .catch(() => setMessage("فشل الحالحجز  تأكدي من البيانات."));
  };

  return (
    <div className="booking-form">
      <h2>احجزي موعدك الآن</h2>

      <label>اختر العيادة:</label>
      <select
        name="service_id"
        value={form.service_id}
        onChange={handleServiceChange}
      >
        <option value="">-- اختر العيادة --</option>
        {Array.isArray(services) && services.map((service) => (
          <option key={service.id} value={service.id}>
            {service.name}
          </option>
        ))}
      </select>

      <label>اسم الدكتور:</label>
      <select
        name="practitioner_id"
        value={form.practitioner_id}
        onChange={handleChange}
      >
        <option value="">اختر الدكتور</option>
        {doctors.map((doc) => (
          <option key={doc.id} value={doc.user_id}>
            {doc.user?.name} - {doc.specialization}
          </option>
        ))}
      </select>

      <label>تاريخ الموعد:</label>
      <input
        type="date"
        name="appointment_date"
        value={form.appointment_date}
        onChange={handleChange}
      />

      <label>الوقت:</label>
      <input
        type="time"
        name="appointment_time"
        value={form.appointment_time}
        onChange={handleChange}
      />

      <button onClick={handleBook}>احجز</button>

      {message && <p>{message}</p>}
    </div>
  );
};

export default BookAppointment;
