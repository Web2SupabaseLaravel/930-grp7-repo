import React, { useEffect, useState, useRef } from "react";
import axios from "axios";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Filler,
  Title,
  Tooltip,
  Legend,
} from "chart.js";
import { Line } from "react-chartjs-2";

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Filler,
  Title,
  Tooltip,
  Legend
);

const AppointmentVolumeChart = ({ period = "daily" }) => {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const chartRef = useRef(null);

  useEffect(() => {
    setLoading(true);
    setError(null);
    axios
      .get(`http://localhost:8000/api/appointment-volume?period=${period}`)
      .then((res) => {
        setData(res.data);
        setLoading(false);
      })
      .catch(() => {
        setError("خطأ في جلب البيانات");
        setLoading(false);
      });
  }, [period]);

  if (loading) return <p>جاري تحميل البيانات...</p>;
  if (error) return <p style={{ color: "red" }}>{error}</p>;
  if (!data.length) return <p>لا توجد بيانات للعرض.</p>;

  const labels = data.map((item) => item.period);
  const totals = data.map((item) => item.total);

  const gradient = chartRef.current
    ? chartRef.current.ctx.createLinearGradient(0, 0, 0, 400)
    : null;
  if (gradient) {
    gradient.addColorStop(0, "rgba(75,192,192,0.7)");
    gradient.addColorStop(1, "rgba(75,192,192,0.1)");
  }

  const chartData = {
    labels,
    datasets: [
      {
        label: "عدد المواعيد",
        data: totals,
        fill: true,
        backgroundColor: gradient || "rgba(75,192,192,0.2)",
        borderColor: "rgba(75,192,192,1)",
        borderWidth: 3,
        tension: 0.4,
        pointRadius: 6,
        pointHoverRadius: 8,
        pointBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBackgroundColor: "#fff",
        pointHoverBorderColor: "rgba(75,192,192,1)",
        shadowOffsetX: 0,
        shadowOffsetY: 4,
        shadowBlur: 10,
        shadowColor: "rgba(0,0,0,0.1)",
      },
    ],
  };

  const options = {
    responsive: true,
    interaction: {
      mode: "nearest",
      intersect: false,
    },
    scales: {
      y: {
        beginAtZero: true,
        suggestedMax: Math.max(...totals) + 2,
        ticks: {
          stepSize: 1,
          color: "#555",
          font: { size: 14, weight: "bold" },
        },
        grid: {
          color: "rgba(200,200,200,0.2)",
          borderDash: [5, 5],
        },
      },
      x: {
        title: {
          display: true,
          text: period === "daily" ? "الساعة" : "الفترة",
          color: "#333",
          font: { size: 16, weight: "bold" },
        },
        ticks: {
          color: "#555",
          font: { size: 14, weight: "bold" },
        },
        grid: {
          display: false,
        },
      },
    },
    plugins: {
      legend: {
        display: true,
        position: "top",
        labels: { font: { size: 16, weight: "bold" }, color: "#333" },
      },
      title: {
        display: true,
        text: `معدل عدد المواعيد (${period})`,
        font: { size: 20, weight: "bold" },
        color: "#222",
        padding: { top: 10, bottom: 20 },
      },
      tooltip: {
        enabled: true,
        backgroundColor: "rgba(0,0,0,0.7)",
        titleFont: { size: 16, weight: "bold" },
        bodyFont: { size: 14 },
        callbacks: {
          label: (context) => `${context.parsed.y} موعد`,
        },
      },
    },
  };

  return (
    <div style={{ maxWidth: "900px", margin: "30px auto", padding: "10px" }}>
      <Line ref={chartRef} data={chartData} options={options} />
    </div>
  );
};

export default AppointmentVolumeChart;
