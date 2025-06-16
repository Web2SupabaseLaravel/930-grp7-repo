import React, { useState } from 'react';
import axios from 'axios';
import './PractitionerForm.css';
const AddPractitioner = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    specialization: '',
    working_hours: '',
    qualifications: ''
  });

  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    setFormData(prev => ({
      ...prev,
      [e.target.name]: e.target.value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessage('');

    try {
       await axios.post('http://localhost:8000/api/practitioners', formData, {
        headers: {
          'Accept': 'application/json',
        }
      });
      setMessage('Practitioner added successfully!');
      setFormData({
        name: '',
        email: '',
        phone: '',
        specialization: '',
        working_hours: '',
        qualifications: ''
      });
    } catch (error) {
      if (error.response && error.response.data) {
        setMessage(`Error: ${JSON.stringify(error.response.data)}`);
      } else {
        setMessage('An error occurred.');
      }
    }
  };

  return (
    <div>
      <h2>Add New Practitioner</h2>
      {message && <p>{message}</p>}
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          name="name"
          placeholder="Name"
          value={formData.name}
          onChange={handleChange}
          required
        /><br />
        <input
          type="email"
          name="email"
          placeholder="Email"
          value={formData.email}
          onChange={handleChange}
          required
        /><br />
        <input
          type="tel"
          name="phone"
          placeholder="Phone"
          value={formData.phone}
          onChange={handleChange}
          required
        /><br />
        <input
          type="text"
          name="specialization"
          placeholder="Specialization"
          value={formData.specialization}
          onChange={handleChange}
          required
        /><br />
        <input
          type="text"
          name="working_hours"
          placeholder="Working Hours"
          value={formData.working_hours}
          onChange={handleChange}
          required
        /><br />
        <input
          type="text"
          name="qualifications"
          placeholder="Qualifications"
          value={formData.qualifications}
          onChange={handleChange}
          required
        /><br />
        <button type="submit">Add Practitioner</button>
      </form>
    </div>
  );
};

export default AddPractitioner;
