import React, { useState } from 'react';
import axios from 'axios';

function PatientForm() {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setSuccess('');

    try {
  await axios.post('http://localhost:8000/api/patients', {
        name,
        email,
        role_id: 1 
      });
      setSuccess('Patient created successfully!');
      setName('');
      setEmail('');
    } catch (err) {
      setError('Failed to create patient. ' + (err.response?.data?.message || err.message));
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <div>
        <label>الاسم:</label>
        <input
          type="text"
          value={name}
          onChange={e => setName(e.target.value)}
          required
        />
      </div>

      <div>
        <label>الايميل:</label>
        <input
          type="email"
          value={email}
          onChange={e => setEmail(e.target.value)}
          required
        />
      </div>

      <button type="submit">إنشاء مريض</button>

      {success && <p style={{ color: 'green' }}>{success}</p>}
      {error && <p style={{ color: 'red' }}>{error}</p>}
    </form>
  );
}

export default PatientForm;
