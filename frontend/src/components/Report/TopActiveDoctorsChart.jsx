import React, { useEffect, useState } from "react";
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
// import "./TopActiveDoctorsChart.css";

const COLORS = ["#4F46E5", "#6366F1", "#818CF8", "#A5B4FC", "#C7D2FE"];

export default function TopActiveDoctorsChart() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/top-active-doctors")
      .then((res) => {
        setData(res.data);
        setLoading(false);
      })
      .catch(() => {
        setError("فشل في تحميل البيانات");
        setLoading(false);
      });
  }, []);

  if (loading) return <div className="chart-loading">جارٍ التحميل...</div>;
  if (error)   return <div className="chart-error">{error}</div>;
  if (!data.length) return <div className="chart-empty">لا توجد بيانات</div>;

  return (
    <div className="chart-card">
      <h2 className="chart-header">أكثر الأطباء نشاطًا</h2>
      <ResponsiveContainer width="100%" height={350}>
        <BarChart
          data={data}
          margin={{ top: 20, right: -39, left: -20, bottom: 20 }}
        >
          <CartesianGrid stroke="#e5e7eb" strokeDasharray="4 4" />
          <XAxis
            dataKey="name"
            tick={{ fill: "#374151", fontSize: 14 }}
            axisLine={false}
            tickLine={false}
          />
          <YAxis
            tick={{ fill: "#374151", fontSize: 14 }}
            axisLine={false}
            tickLine={false}
            label={{
              value: "عدد المواعيد",
              angle: -90,
              position: "insideLeft",
              fill: "#6b7280",
              fontSize: 12,
            }}
          />
          <Tooltip
            cursor={{ fill: "rgba(99, 102, 241, 0.1)" }}
            contentStyle={{ borderRadius: 8 }}
          />
          <Bar dataKey="appointments" radius={[8, 8, 0, 0]}>
            {data.map((_, idx) => (
              <Cell
                key={`cell-${idx}`}
                fill={COLORS[idx % COLORS.length]}
              />
            ))}
          </Bar>
        </BarChart>
      </ResponsiveContainer>
    </div>
  );
}
