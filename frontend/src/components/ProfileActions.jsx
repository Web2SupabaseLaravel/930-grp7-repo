import React from 'react';

const ProfileActions = () => {
  return (
    <div className="flex justify-center gap-4 mt-4">
      <button className="bg-red-500 text-white px-4 py-2 rounded">تسجيل الخروج</button>
      <button className="bg-blue-500 text-white px-4 py-2 rounded">تعديل المعلومات</button>
    </div>
  );
};

export default ProfileActions;
