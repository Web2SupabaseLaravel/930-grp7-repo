import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Line, Bar } from 'react-chartjs-2';
import 'chart.js/auto';

export default function PractitionerReportCard() {
  const [practitioners, setPractitioners] = useState([]);
  const [selectedId, setSelectedId] = useState('');
  const [stats, setStats] = useState({
    dailyAppointments: null,
    avgDuration: null,
    cancelled: null,
    weeklyData: [],
    noShowData: []
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    axios.get('http://localhost:8000/api/practitioners')
      .then(res => {
        console.log('بيانات المتمرسين:', res.data);
        setPractitioners(res.data);
      })
      .catch(err => {
        console.error('خطأ جلب المتمرسين:', err);
        setError('فشل في جلب قائمة المتمرسين');
      });
  }, []);

  const fetchReport = async () => {
    if (!selectedId) {
      setError('اختر متمرس أولاً');
      return;
    }
    setLoading(true);
    setError(null);

    try {
      const [
        dailyRes,
        avgRes,
        cancelRes,
        weeklyRes,
        noShowRes
      ] = await Promise.all([
        axios.get(`http://localhost:8000/api/practitioner/daily-appointments`, { params: { practitioner_id: selectedId } }),
        axios.get(`http://localhost:8000/api/practitioner/daily-average-duration`, { params: { practitioner_id: selectedId } }),
        axios.get(`http://localhost:8000/api/practitioner/daily-cancelled`, { params: { practitioner_id: selectedId } }),
        axios.get(`http://localhost:8000/api/practitioner/weekly-appointments`, { params: { practitioner_id: selectedId } }),
        axios.get(`http://localhost:8000/api/practitioner/no-show-by-day`, { params: { practitioner_id: selectedId } })
      ]);

      console.log('dailyRes:', dailyRes.data);
      console.log('avgRes:', avgRes.data);
      console.log('cancelRes:', cancelRes.data);
      console.log('weeklyRes:', weeklyRes.data);
      console.log('noShowRes:', noShowRes.data);

      setStats({
        dailyAppointments: dailyRes.data.appointments,
        avgDuration: avgRes.data.average_duration,
        cancelled: cancelRes.data.cancelled,
        weeklyData: weeklyRes.data,
        noShowData: noShowRes.data
      });

    } catch (error) {
      console.error('خطأ جلب التقرير:', error);
      setError('فشل في جلب التقرير');
    }

    setLoading(false);
  };

  const lineData = {
    labels: Array.isArray(stats.weeklyData) ? stats.weeklyData.map(r => r.day) : [],
    datasets: [{
      label: 'عدد المواعيد',
      data: Array.isArray(stats.weeklyData) ? stats.weeklyData.map(r => r.count) : [],
      borderColor: '#007bff',
      backgroundColor: 'rgba(0,123,255,0.1)',
      tension: 0.3
    }]
  };

  const barData = {
    labels: Array.isArray(stats.noShowData) ? stats.noShowData.map(r => r.day) : [],
    datasets: [{
      label: 'نسبة عدم الحضور (%)',
      data: Array.isArray(stats.noShowData) ? stats.noShowData.map(r => r.percent) : [],
      backgroundColor: '#dc3545'
    }]
  };

  return (
    <div style={{ maxWidth: 600, margin: '40px auto', fontFamily: 'Arial, sans-serif' }}>
      <h2 style={{ textAlign: 'center' }}>تقرير خاص بطبيب</h2>
      <select
        value={selectedId}
        onChange={e => setSelectedId(e.target.value)}
        style={{ width: '100%', padding: '8px', fontSize: '16px' }}
      >
        <option value="">-- اختر متمرس --</option>
        {Array.isArray(practitioners) && practitioners.length > 0 ? (
          practitioners.map(p => (
            <option key={p.id} value={p.id}>{p.user?.name || p.name || 'بدون اسم'}</option>
          ))
        ) : (
          <option disabled>لا توجد بيانات للمتمرسين</option>
        )}
      </select>

      <button
        onClick={fetchReport}
        style={{
          marginTop: 15, width: '100%', padding: 10,
          fontSize: 16, cursor: 'pointer',
          backgroundColor: '#007bff', color: '#fff',
          border: 'none', borderRadius: 5
        }}
      >
        عرض التقرير
      </button>

      {loading && <p style={{ textAlign: 'center' }}>جارٍ التحميل...</p>}
      {error && <p style={{ color: 'red', textAlign: 'center' }}>{error}</p>}

      {!loading && !error && stats.dailyAppointments !== null && (
        <div style={{ marginTop: 30 }}>
<div style={{ 
  display: 'flex', 
  gap: '16px', 
  justifyContent: 'space-between', 
  flexWrap: 'wrap', 
  fontFamily: '"Segoe UI", Tahoma, Geneva, Verdana, sans-serif'
}}>
  <div style={{
    flex: '1',
    backgroundColor: '#007bff',
    color: '#fff',
    padding: '20px',
    borderRadius: '12px',
    textAlign: 'center',
    boxShadow: '0 4px 12px rgba(0,0,0,0.1)'
  }}>
    <p style={{ fontSize: '16px', marginBottom: '8px' }}>المواعيد اليوم</p>
    <h3 style={{ fontSize: '28px', margin: 0 }}>{stats.dailyAppointments}</h3>
  </div>

  <div style={{
    flex: '1',
    backgroundColor: '#28a745',
    color: '#fff',
    padding: '20px',
    borderRadius: '12px',
    textAlign: 'center',
    boxShadow: '0 4px 12px rgba(0,0,0,0.1)'
  }}>
    <p style={{ fontSize: '16px', marginBottom: '8px' }}>متوسط المدة</p>
  <h3 style={{ fontSize: '28px', margin: 0 }}>
  {parseFloat(stats.avgDuration).toFixed(2)} دقائق
</h3>

  </div>

  <div style={{
    flex: '1',
    backgroundColor: '#dc3545',
    color: '#fff',
    padding: '20px',
    borderRadius: '12px',
    textAlign: 'center',
    boxShadow: '0 4px 12px rgba(0,0,0,0.1)'
  }}>
    <p style={{ fontSize: '16px', marginBottom: '8px' }}>المواعيد الملغاة</p>
    <h3 style={{ fontSize: '28px', margin: 0 }}>{stats.cancelled}</h3>
  </div>
</div>


          <div style={{ marginTop: 40 }}>
            <h4>المواعيد هذا الأسبوع</h4>
            <Line data={lineData} />
          </div>

          <div style={{ marginTop: 40 }}>
            <h4>نسبة عدم الحضور حسب اليوم</h4>
            <Bar
              data={barData}
              options={{
                scales: { y: { beginAtZero: true, max: 100 } }
              }}
            />
          </div>
        </div>
      )}
    </div>
  );
}
