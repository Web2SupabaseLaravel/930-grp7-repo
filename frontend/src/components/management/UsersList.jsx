import React, { useEffect, useState } from "react";
import UserRow from "./UserRow";
import "./UsersList.css";

export default function UsersList() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost:8000/api/users") // عدّل الـ URL حسب إعداداتك
      .then((res) => res.json())
      .then((data) => {
        setUsers(data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("خطأ في جلب المستخدمين:", err);
        setLoading(false);
      });
  }, []);

  return (
    <div className="management-card">
      <h3>قائمة المستخدمين</h3>

      {loading ? (
        <p>جاري التحميل...</p>
      ) : (
        <table className="users-table">
          <thead>
            <tr>
              <th>الاسم</th>
              <th>البريد الإلكتروني</th>
              <th>الدور</th>
            </tr>
          </thead>
          <tbody>
            {users.length > 0 ? (
              users.map((user) => <UserRow key={user.id} user={user} />)
            ) : (
              <tr>
                <td colSpan="3" style={{ textAlign: "center" }}>
                  لا يوجد مستخدمون
                </td>
              </tr>
            )}
          </tbody>
        </table>
      )}
    </div>
  );
}
