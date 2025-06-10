import "./navbar.css";

export default function Navbar() {
  return (
    <nav className="navbar">
      <div className="logo">
        Medi<span className="highlight">Book</span>
      </div>
      <ul className="nav-links">
         <li><a href="#home">الصفحة الرئيسية</a></li>
        <li><a href="#contact">اتصل بنا</a></li>
        <li><a href="#booking">حجز موعد</a></li>
        <li><a href="#services">الخدمات</a></li>
      </ul>
      <button className="login-btn">تسجيل الدخول</button>
    </nav>
  );
}
