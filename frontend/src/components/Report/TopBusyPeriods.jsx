import React, { useEffect, useState } from "react";
// import './TopBusyPeriods.css'
import axios from "axios";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  Tooltip,
  ResponsiveContainer,
  CartesianGrid,
  Cell,
} from "recharts";

const COLORS = ["#8884d8", "#82ca9d", "#ffc658", "#ff8042", "#a4de6c"];
const daysOfWeek = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];

export default function TopBusyDaysChart() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    setLoading(true);
    setError(null);
    axios
      .get("http://localhost:8000/api/top-busy-days")
      .then((res) => {
        const formattedData = res.data.map(item => {
          const date = new Date(item.day);
          const dayName = daysOfWeek[date.getDay()];
          return { ...item, day: dayName };
        });
        setData(formattedData);
        setLoading(false);
      })
      .catch(() => {
        setError("فشل في تحميل البيانات");
        setLoading(false);
      });
  }, []);

  if (loading) return <p className="chart-text">جارٍ التحميل...</p>;
  if (error) return <p className="chart-text">{error}</p>;
  if (data.length === 0) return <p className="chart-text">لا توجد بيانات لعرضها</p>;

  return (
    <div className="chart-container">
      <h2 className="chart-title">أكثر 5 أيام ازدحامًا</h2>
      <ResponsiveContainer width="100%" height={350}>
        <BarChart
          layout="vertical"
          data={data}
          margin={{ top: 20, right: 10, left: -80, bottom: 10 }}
        >
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis
            type="number"
            label={{ value: 'معدل الازدحام', position: 'insideBottomRight', offset: 0 }}
            tickCount={5}
          />
          <YAxis
            type="category"
            dataKey="day"
            label={{ value: 'اليوم', angle: -90, position: 'insideLeft' }}
            width={100}
          />
          <Tooltip />
          <Bar dataKey="count" fill="#8884d8">
            {data.map((_, index) => (
              <Cell key={`cell-${index}`} fill={COLORS[index % COLORS.length]} />
            ))}
          </Bar>
        </BarChart>
      </ResponsiveContainer>
    </div>
  );
}
