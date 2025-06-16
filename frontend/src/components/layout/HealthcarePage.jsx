import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './HealthcarePage.css';

const HealthcarePage = () => {
  const [doctors, setDoctors] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    axios.get('http://localhost:8000/api/practitioners')
      .then(response => {
        setDoctors(response.data);
        setLoading(false);
      })
    .catch(() => {
    setError('حدث خطأ في تحميل البيانات');
    setLoading(false);
    });
  }, []);

  return (
    <div className="healthcare-page">
      <div className="hero-section">
        <h1>رعايتك الصحية تبدأ من هنا</h1>
        <p>احجز مواعيدك بسهولة، وتواصل مع أفضل الأطباء في أي وقت ومن أي مكان.</p>
      </div>

      <div className="divider"></div>

      <div className="why-us-section">
        <h2>لماذا تختارنا؟</h2>
        <div className="features">
          <div className="feature">
            <h3>تواصل مباشر</h3>
            <p>إمكانية التواصل مع الطبيب قبل الموعد</p>
          </div>
          <div className="feature">
            <h3>أطباء مختصون</h3>
            <p>فريق طبي محترف في مختلف التخصصات الطبية</p>
          </div>
          <div className="feature">
            <h3>سهولة الحجز</h3>
            <p>نظام حجز الكتروني سريع وفعال بدون الحاجة للانتظار</p>
          </div>
        </div>
      </div>

      <div className="doctors-section">
        <h2>فريق الأطباء</h2>
        <div className="doctors">
          {loading && <p>جاري تحميل الأطباء...</p>}
          {error && <p style={{ color: 'red' }}>{error}</p>}
          {!loading && !error && doctors.length === 0 && <p>لا يوجد أطباء حالياً</p>}

          {!loading && !error && doctors.map((doctor) => (
            <div key={doctor.id} className="doctor">
              <h3>{doctor.user?.name || 'اسم غير متوفر'}</h3>
              <p>
                <strong>
                  {doctor.specialization && doctor.specialization !== 'null'
                    ? doctor.specialization
                    : 'تخصص غير محدد'}
                </strong>
              </p>
            </div>
          ))}
        </div>
      </div>

      <div className="info-section">
        <div className="info-column">
          <h4>تواصل معنا</h4>
          <p>info@example.com</p>
          <p>0123456789</p>
        </div>
        <div className="info-column">
          <h4>روابط سريعة</h4>
          <p>الرئيسية</p>
          <p>عن الخدمة</p>
          <p>الأسئلة الشائعة</p>
        </div>
        <div className="info-column">
          <h4>المنصة الطبية الذكية</h4>
          <p>نحن نسعى إلى تقديم رعاية صحية صحيحة وسهولة الوصول في كل وقت.</p>
        </div>
      </div>
    </div>
  );
};

export default HealthcarePage;
