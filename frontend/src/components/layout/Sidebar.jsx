import React from 'react';
import { Link } from 'react-router-dom';

export default function Sidebar({ isOpen, toggleSidebar }) {
  const menuItems = [
    { label: 'الرئيسية', to: '/' },
    { label: 'المستخدمون', to: '/users' },
    { label: 'الممارسون', to: '/practitioners' },
    { label: 'المواعيد', to: '/appointments' },
    { label: 'التقارير', to: '/reports' },
    { label: 'الإعدادات', to: '/settings' }
  ];

  return (
    <aside className={`sidebar ${isOpen ? 'visible' : ''}`}>
      <h2 className="sidebar-title">القائمة الجانبية</h2>
      <ul className="sidebar-menu">
        {menuItems.map(item => (
          <li key={item.label} onClick={toggleSidebar}>
            <Link to={item.to}>{item.label}</Link>
          </li>
        ))}
      </ul>
    </aside>
  );
}
