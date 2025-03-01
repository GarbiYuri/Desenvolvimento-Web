import axios from 'axios';
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

function Index() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);
  const navigate = useNavigate(); // Para redirecionar o usuário

  const handleSubmit = async (event) => {
    event.preventDefault();
    
    try {
      // Envia as credenciais para o back-end PHP
      const response = await axios.post('http://localhost:8000/public/index.php', { 
        username, 
        password 
      });
      
      if (response.data.status === 'success') {
        setSuccess('Login bem-sucedido');
        setError(null);

        // Redireciona para a página "List"
        navigate('/Dashboard', {state: {username}});
      } else {
        setError(response.data.message || 'Erro desconhecido');
        setSuccess(null);
      }
    } catch (error) {
      setError('Erro de rede. Tente novamente.');
      setSuccess(null);
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="w-full max-w-md p-8 space-y-6 bg-white shadow-lg rounded-lg">
        <h2 className="text-2xl font-bold text-center text-gray-800">Sign In</h2>

        {error && <p className="text-red-500 text-center">{error}</p>}
        {success && <p className="text-green-500 text-center">{success}</p>}

        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label htmlFor="username" className="block text-sm font-medium text-gray-700">Username</label>
            <input
              id="username"
              name="username"
              type="text"
              required
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              className="w-full px-4 py-2 mt-1 text-gray-900 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
              placeholder="Enter your username"
            />
          </div>
          <div>
            <label htmlFor="password" className="block text-sm font-medium text-gray-700">Password</label>
            <input
              id="password"
              name="password"
              type="password"
              required
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              className="w-full px-4 py-2 mt-1 text-gray-900 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
              placeholder="Enter your password"
            />
          </div>
          <div className="flex w-full gap-2">
  <button
    type="submit"
    className="w-1/2 px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300"
  >
    Sign In
  </button>
  <a
    href="/Signup"
    className="w-1/2 px-4 py-2 text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300"
  >
    Sign up
  </a>
</div>
        </form>
        
      </div>
    </div>
  );
}

export default Index;
