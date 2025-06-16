import React from "react";
import "./Footer.css";

export default function Footer() {
  return (
    <footer className="footer">
      <div className="container">
        <div className="footer-info">
          © 2025 MediBook. كل الحقوق محفوظة.
        </div>
        <div className="footer-links">
          <a href="/">الرئيسية</a>
          <a href="/services">الخدمات</a>
          <a href="/contact">تواصل معنا</a>
          <a href="/privacy">سياسة الخصوصية</a>
        </div>
      </div>
    </footer>
  );
}
