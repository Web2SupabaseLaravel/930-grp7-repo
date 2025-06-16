// src/pages/Register.jsx
import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import './Register.css';

function Register() {
  const [form, setForm] = useState({
    fullName: '',
    email: '',
    phone: '',
    password: '',
    confirmPassword: '',
    agreeTerms: false
  });

  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setForm({
      ...form,
      [name]: type === 'checkbox' ? checked : value
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (form.password !== form.confirmPassword) {
      setMessage('كلمة المرور وتأكيدها غير متطابقين');
      return;
    }
    
    if (!form.agreeTerms) {
      setMessage('يجب الموافقة على الشروط والأحكام');
      return;
    }

    try {
      const response = await fetch("http://127.0.0.1:8000/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json"
        },
        body: JSON.stringify({
          name: form.fullName,
          email: form.email,
          phone: form.phone,
          password: form.password,
          password_confirmation: form.confirmPassword
        })
      });

      const data = await response.json();

      if (response.ok) {
        setMessage("✅ تم التسجيل بنجاح!");

      } else {
        setMessage(`❌ خطأ: ${data.message || 'حدث خطأ أثناء التسجيل'}`);
      }
    } catch (error) {
      setMessage(`❌ خطأ في الاتصال: ${error.message}`);
    }
  };

  return (
    <div className="register-container">
      <div className="register-header">
        <h1 className="logo">MediBook</h1>
        <p className="tagline">حجز موعد الخدمات</p>
      </div>

      <div className="register-card">
        <div className="language-switcher">
          <button className="lang-btn active">العربية</button>
          <button className="lang-btn">English</button>
        </div>

        <h2 className="register-title">تسجيل حساب جديد</h2>
        <p className="login-prompt">هل لديك حساب بالفعل؟    <Link to="/" className="text-decoration-none">Login here</Link> </p>

        {message && (
          <div className={`alert-message ${message.includes('✅') ? 'success' : 'error'}`}>
            {message}
          </div>
        )}

        <form onSubmit={handleSubmit}>
          <div className="form-group">
            <label htmlFor="fullName">الاسم</label>
            <input
              type="text"
              id="fullName"
              name="fullName"
              placeholder="الاسم كامل هنا"
              value={form.fullName}
              onChange={handleChange}
              required
            />
          </div>

          <div className="form-group">
            <label htmlFor="email">البريد الالكتروني</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="ex-patients@example.com"
              value={form.email}
              onChange={handleChange}
              required
            />
          </div>

          <div className="form-group">
            <label htmlFor="phone">رقم الهاتف</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              placeholder="ex: +972 123 456 789"
              value={form.phone}
              onChange={handleChange}
              required
            />
          </div>

          <div className="form-group">
            <label htmlFor="password">كلمة المرور</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="كلمة المرور"
              value={form.password}
              onChange={handleChange}
              required
              minLength="6"
            />
          </div>

          <div className="form-group">
            <label htmlFor="confirmPassword">تأكيد كلمة المرور</label>
            <input
              type="password"
              id="confirmPassword"
              name="confirmPassword"
              placeholder="تأكيد كلمة المرور"
              value={form.confirmPassword}
              onChange={handleChange}
              required
              minLength="6"
            />
          </div>

          <div className="terms-group">
            <input
              type="checkbox"
              id="agreeTerms"
              name="agreeTerms"
              checked={form.agreeTerms}
              onChange={handleChange}
              required
            />
            <label htmlFor="agreeTerms">أوافق على التسجيل والشروط</label>
          </div>

          <button type="submit" className="register-btn">تسجيل حساب جديد</button>
        </form>
      </div>

      <div className="register-footer">
        <p className="slogan">"انضم إلى ميدى بوك الآن، واحجز مواعيدك الطبية بكل سهولة وأنت في مكانك، عبر هاتفك الذكي"</p>
        <p className="copyright">© {new Date().getFullYear()} MediBook. جميع الحقوق محفوظة</p>
      </div>
    </div>
  );
}

export default Register;