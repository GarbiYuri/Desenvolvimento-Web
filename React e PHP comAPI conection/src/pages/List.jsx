// List.jsx
import React from 'react';
import { useLocation } from "react-router-dom";

function List() {
  const location = useLocation();
  const username = location.state?.username || "User"; // Recuperando state
  return (
    <div className="flex min-h-screen bg-gray-100 text-gray-800">
      {/* Sidebar */}
      <div className="w-64 bg-blue-600 text-white flex flex-col p-4">
        <h2 className="text-2xl font-bold mb-6">My Dashboard</h2>
        <nav className="flex flex-col space-y-4">
          <a href="/Profile" className="hover:bg-blue-500 p-2 rounded">Profile</a>
          <a href="/" className="hover:bg-red-500 p-2 rounded">Logout</a>
        </nav>
      </div>

      {/* Main Content */}
      <div className="flex-1 p-6">
        <header className="flex justify-between items-center mb-8">
          <h1 className="text-3xl font-semibold">Welcome, {username}!</h1>
        </header>
        {/* Aqui você pode adicionar conteúdo adicional */}
      </div>
    </div>
  );
}

export default List;
