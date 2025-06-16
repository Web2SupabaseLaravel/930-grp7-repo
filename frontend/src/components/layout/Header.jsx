import React, { useState, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";
import "./Header.css";

export default function Header() {
  const [user, setUser] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    const stored = localStorage.getItem("user");
    if (stored) {
      setUser(JSON.parse(stored));
    }
  }, []);

  const handleLogout = () => {
    localStorage.removeItem("user");
    localStorage.removeItem("token");
    navigate("/login");
  };

  const profilePath = user
    ? user.role_id === 1
      ? "/AdminDashboard"
      : user.role_id === 2
        ? "/practitioner-profile"
        : "/patient-profile"
    : "";

  return (
    <header className="header">
      <div className="container">
        <div className="logo">
          Medi<span className="highlight">Book</span>
        </div>
        <nav className="nav-links">
          <Link to="/">الرئيسية</Link>
          <Link to="/services">الخدمات</Link>
          <Link to="/contact">تواصل معنا</Link>

          {user ? (
            <>
              <span className="welcome">مرحباً، {user.name}</span>
              <Link to={profilePath} className="my-profile">
                حسابي
              </Link>
              <button onClick={handleLogout} className="logout-btn">
                تسجيل الخروج
              </button>
            </>
          ) : (
            <>
              <Link to="/login" className="login-btn">تسجيل الدخول</Link>
              <Link to="/register" className="register-btn">إنشاء حساب</Link>
            </>
          )}
        </nav>
      </div>
    </header>
  );
}
