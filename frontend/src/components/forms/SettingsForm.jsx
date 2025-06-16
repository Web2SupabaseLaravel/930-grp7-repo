import React, { useState } from "react";
import axios from "axios";
import "./SettingsForm.css";

const SettingsForm = () => {
  const [settings, setSettings] = useState({
    clinicName: "MediBook",
    workingHours: "08:00 - 18:00",
    contactEmail: "info@medibook.com",
    phoneNumber: "+1234567890",
  });

  const [message, setMessage] = useState("");

  const handleChange = (e) => {
    const { name, value } = e.target;
    setSettings((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessage("");
    try {
      const response = await axios.post("http://localhost:8000/api/settings", settings, {
        headers: {
          Accept: "application/json",
        },
      });
      setMessage(response.data.message);
    } catch (error) {
      setMessage("حدث خطأ أثناء حفظ الإعدادات.");
      console.error(error);
    }
  };

  return (
    <div className="settings-form-container">
      <h2>إعدادات النظام</h2>
      <form onSubmit={handleSubmit} className="settings-form">
        <label>اسم العيادة:</label>
        <input
          type="text"
          name="clinicName"
          value={settings.clinicName}
          onChange={handleChange}
          required
        />

        <label>ساعات العمل:</label>
        <input
          type="text"
          name="workingHours"
          value={settings.workingHours}
          onChange={handleChange}
          required
        />

        <label>البريد الإلكتروني للتواصل:</label>
        <input
          type="email"
          name="contactEmail"
          value={settings.contactEmail}
          onChange={handleChange}
          required
        />

        <label>رقم الهاتف:</label>
        <input
          type="tel"
          name="phoneNumber"
          value={settings.phoneNumber}
          onChange={handleChange}
          required
        />

        <button type="submit" className="save-btn">
          حفظ الإعدادات
        </button>
      </form>

      {message && <p className="message">{message}</p>}
    </div>
  );
};

export default SettingsForm;
