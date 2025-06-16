import React, { useEffect, useState } from "react";
import "./CancellationNoShowChart.css";
import axios from 'axios';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend,
} from "chart.js";
import { Bar } from "react-chartjs-2";

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend
);

const CancellationNoShowStats = () => {
  const [data, setData] = useState({ cancellation_rates: [], no_show_rates: [] });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get('http://localhost:8000/api/cancellation-no-show')
      .then((res) => {
        console.log(res.data);
        setData(res.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error fetching data:", err);
        setLoading(false);
      });
  }, []);

  if (loading) return <p style={{ textAlign: "center", marginTop: "50px" }}>جاري تحميل البيانات...</p>;

  const chartData = {
    labels: data.cancellation_rates.map((item) => item.name),
    datasets: [
      {
        label: "نسبة الإلغاء (%)",
        data: data.cancellation_rates.map((item) => item.cancellation_rate_percent),
        backgroundColor: "rgba(255, 99, 132, 0.6)",
      },
      {
        label: "عدد عدم الحضور",
        data: data.cancellation_rates.map((item) => {
          const noShow = data.no_show_rates.find(ns => ns.practitioner_id === item.practitioner_id);
          return noShow ? noShow.no_show_count : 0;
        }),
        backgroundColor: "rgba(54, 162, 235, 0.6)",
      },
    ],
  };

  const chartOptions = {
    responsive: true,
    plugins: {
      legend: { position: "top" },
      title: {
        display: true,
        text: "إحصائيات الإلغاء وعدم الحضور",
      },
    },
  };

  return (
    <div className="container">
      <h2>نسب الإلغاء وعدم الحضور لكل ممارس</h2>

      <table>
        <thead>
          <tr>
            <th>الطبيب</th>
            <th>نسبة الإلغاء (%)</th>
            <th>عدد عدم الحضور</th>
          </tr>
        </thead>
        <tbody>
          {data.cancellation_rates.map((item) => {
            const noShow = data.no_show_rates.find(ns => ns.practitioner_id === item.practitioner_id);
            return (
              <tr key={item.practitioner_id}>
                <td>{item.name}</td>
                <td>{item.cancellation_rate_percent}</td>
                <td>{noShow ? noShow.no_show_count : 0}</td>
              </tr>
            );
          })}
        </tbody>
      </table>

<div className="chart-container">
  <Bar data={chartData} options={chartOptions} height={400} width={900} />
</div>
    </div>
  );
};

export default CancellationNoShowStats;
