import React, { useState } from 'react';
import { Link } from 'react-router-dom';

function Register() {
  const [form, setForm] = useState({
    name: '',
    age: '',
    email: '',
    password: '',
    role: ''
  });

  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    let role_id;
    switch (form.role) {
      case 'admin':
        role_id = 1;
        break;
      case 'patient':
        role_id = 2;
        break;
      case 'practitioner':
        role_id = 3;
        break;
      default:
        role_id = null;
    }

    if (!role_id) {
      setMessage('❌ Please select a valid role.');
      return;
    }

    try {
      const response = await fetch("http://127.0.0.1:8000/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          name: form.name,
          age: form.age,
          email: form.email,
          password: form.password,
          role_id: role_id
        })
      });

      const data = await response.json();

      if (response.ok) {
        setMessage("✅ Registered successfully!");
      } else {
        setMessage(`❌ Error: ${data.message}`);
      }
    } catch (error) {
      setMessage(`❌ Error: ${error.message}`);
    }
  };

  return (
    <div className="container d-flex align-items-center justify-content-center min-vh-100">
      <div className="card shadow p-4" style={{ width: '100%', maxWidth: '400px' }}>
        <h2 className="text-center mb-4">Create Account</h2>

        {message && <div className="alert alert-info text-center">{message}</div>}

        <form onSubmit={handleSubmit}>
          <div className="mb-3">
            <label className="form-label">Full Name</label>
            <input
              name="name"
              type="text"
              className="form-control"
              placeholder="Enter your name"
              onChange={handleChange}
              required
            />
          </div>

          <div className="mb-3">
            <label className="form-label">Age</label>
            <input
              name="age"
              type="number"
              className="form-control"
              placeholder="Enter your age"
              onChange={handleChange}
              required
            />
          </div>

          <div className="mb-3">
            <label className="form-label">Email</label>
            <input
              name="email"
              type="email"
              className="form-control"
              placeholder="Enter your email"
              onChange={handleChange}
              required
            />
          </div>

          <div className="mb-3">
            <label className="form-label">Password</label>
            <input
              name="password"
              type="password"
              className="form-control"
              placeholder="Enter your password"
              onChange={handleChange}
              required
            />
          </div>

          <div className="mb-4">
            <label className="form-label">Role</label>
            <select
              name="role"
              className="form-select"
              onChange={handleChange}
              required
            >
              <option value="">Select role</option>
              <option value="admin">Admin</option>
              <option value="patient">Patient</option>
              <option value="practitioner">Practitioner</option>
            </select>
          </div>

          <button type="submit" className="btn btn-primary w-100">
            Register
          </button>
        </form>

        <p className="text-center mt-3">
          Already have an account?{' '}
          <Link to="/" className="text-decoration-none">Login here</Link>
        </p>
      </div>
    </div>
  );
}

export default Register;
