import React from 'react';
import EmployeeInfo from '../components/EmployeeInfo';
import EmployeeStats from '../components/EmployeeStats';
import './EmployeeProfilePage.css';

function EmployeeProfilePage() {
  return (
    <div className="employee-page">
      <h1 className="page-title">اسم الموظف</h1>
      <EmployeeInfo />
      <EmployeeStats />
    </div>
  );
}

useEffect(() => {
    const fetchEmployeeData = async () => {
      try {
        const token = localStorage.getItem('token');
  
        const profileRes = await axios.get('http://127.0.0.1:8000/api/profile', {
          headers: { Authorization: `Bearer ${token}` }
        });
        setProfile(profileRes.data.data);
  
      
        const statsRes = await axios.get('http://127.0.0.1:8000/api/employee/stats', {
          headers: { Authorization: `Bearer ${token}` }
        });
        setStats(statsRes.data); 
      } catch (error) {
        console.error('Error fetching employee data:', error);
      }
    };
  
    fetchEmployeeData();
  }, []);
  
export default EmployeeProfilePage;
