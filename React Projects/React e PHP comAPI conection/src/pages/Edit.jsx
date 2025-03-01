// EditProfile.js
import axios from 'axios';
import React, { useState } from 'react';

function EditProfile() {
  const [username, setUsername] = useState(''); // Pode ser preenchido com o valor inicial obtido da API
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [result, setResult] = useState(''); // Mensagem de erro ou sucesso

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (password !== confirmPassword) {
      setResult("Passwords don't match");
      return;
    }

    try {
      // Envia os dados de edição para o back-end PHP
      const response = await axios.post('http://localhost:8000/public/edit.php', { 
        username, 
        password
      });
      
      if (response.data.status === 'success') {
        // Se o cadastro for bem-sucedido
        setResult('Profile updated successfully');
        setError(null);
        
        // Redireciona ou exibe uma mensagem
        setTimeout(() => {
          window.location.href = '/List'; // Redireciona para a página de login
        }, 2000);
      } else {

        // Exibe a mensagem de erro
        setError(response.data.message || 'Erro desconhecido');
        setSuccess(null);
      }
    } catch (error) {
      setError('Erro de rede. Tente novamente.');
      setSuccess(null);
    }
  };
    

  const handleDelete = () => {
    const confirmed = window.confirm('Tem certeza que deseja excluir este produto?');
    if (confirmed) {
      // Aqui você chamaria a API para deletar o perfil
      // Exemplo: fetch('/api/delete-user', { method: 'DELETE', body: JSON.stringify({ id }) })
      setResult('Account deleted');
    }
  };

  return (
    <div className="flex min-h-screen bg-gray-100 text-gray-800">
      {/* Sidebar */}
      <div className="w-64 bg-blue-600 text-white flex flex-col p-4">
        <h2 className="text-2xl font-bold mb-6">Dashboard</h2>
        <nav className="flex flex-col space-y-4">
          <a href="/Dashboard" className="hover:bg-blue-500 p-2 rounded">Home</a>
          <a href="/logout" className="hover:bg-red-500 p-2 rounded">Logout</a>
        </nav>
      </div>

      {/* Main Content */}
      <div className="flex-1 p-6">
        <header className="flex justify-between items-center mb-8">
          <h1 className="text-3xl font-semibold">Edit Profile</h1>
        </header>

        {/* Edit Profile Form */}
        <div className="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
          <form onSubmit={handleSubmit} className="space-y-6">
            {/* New Username */}
            <div>
              <label htmlFor="username" className="block text-sm font-medium text-gray-700">New Username</label>
              <input
                id="username"
                name="username"
                type="text"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
                className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter your new username"
                required
              />
            </div>

            {/* New Password */}
            <div>
              <label htmlFor="password" className="block text-sm font-medium text-gray-700">New Password</label>
              <input
                id="password"
                name="password"
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter a new password"
              />
            </div>

            {/* Confirm Password */}
            <div>
              <label htmlFor="confirmPassword" className="block text-sm font-medium text-gray-700">Confirm New Password</label>
              <input
                id="confirmPassword"
                name="confirmPassword"
                type="password"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                className="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Confirm your new password"
              />
            </div>

            {/* Save Button */}
            <div className="flex justify-end">
              <button
                type="submit"
                className="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300"
              >
                Save Changes
              </button>
            </div>
          </form>

          {/* Delete Account Link */}
          <div className="mt-4 text-right">
            <button onClick={handleDelete} className="text-red-600 hover:underline">
              Excluir
            </button>
          </div>

          {/* Display Result Message */}
          {result && (
            <p className="text-center mt-4 text-red-500">
              {result}
            </p>
          )}
        </div>
      </div>
    </div>
  );
}

export default EditProfile;
