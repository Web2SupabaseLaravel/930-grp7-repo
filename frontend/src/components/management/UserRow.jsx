import React from "react";
import "./UserRow.css";

const UserRow = ({ user }) => {
  return (
    <tr className="user-row">
      <td>{user.name}</td>
      <td>{user.email}</td>
      <td>{user.role}</td>
      <td>
        <span className={user.active ? "status-active" : "status-inactive"}>
          {user.active ? "نشط" : "غير نشط"}
        </span>
      </td>
    </tr>
  );
};

export default UserRow;
