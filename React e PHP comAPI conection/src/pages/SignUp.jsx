import axios from 'axios';
import React, { useState } from 'react';

function SignUp() {
  const [username, setUsername] = useState('');
  const [passwords, setPassword] = useState('');
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);

  const handleSubmit = async (event) => {
    event.preventDefault();
    
    try {
      // Envia os dados de cadastro para o back-end PHP
      const response = await axios.post('http://localhost:8000/public/signup.php', { 
        username, 
        passwords
      });
      
      if (response.data.status === 'success') {
        // Se o cadastro for bem-sucedido
        setSuccess('Cadastro bem-sucedido! Redirecionando para login...');
        setError(null);
        
        // Redireciona ou exibe uma mensagem
        setTimeout(() => {
          window.location.href = '/'; // Redireciona para a página de login
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

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="w-full max-w-md p-8 space-y-6 bg-white shadow-lg rounded-lg">
        <h2 className="text-2xl font-bold text-center text-gray-800">Sign Up</h2>

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
              placeholder="Choose a username"
            />
          </div>
          <div>
            <label htmlFor="passwords" className="block text-sm font-medium text-gray-700">Password</label>
            <input
              id="passwords"
              name="passwords"
              type="password"
              required
              value={passwords}
              onChange={(e) => setPassword(e.target.value)}
              className="w-full px-4 py-2 mt-1 text-gray-900 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
              placeholder="Create a password"
            />
          </div>
          <div>
            <button
              type="submit"
              className="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300"
            >
              Sign Up
            </button>
          </div>
        </form>
        <div className="text-sm text-center text-gray-600">
          <p>Already have an account? 
            <a href="/" className="font-medium text-blue-600 hover:text-blue-500">Sign In</a>
          </p>
        </div>
      </div>
    </div>
  );

}

export default SignUp;
