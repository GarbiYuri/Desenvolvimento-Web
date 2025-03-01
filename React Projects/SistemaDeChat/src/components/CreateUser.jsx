import { Link } from 'react-router-dom';
import { useState } from 'react';
import axios from 'axios';

function CreateUser() {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    username: '',
    password: '',
  });

  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    try {
      const response = await axios.post('http://localhost:8000/public/User/signup.php', formData);
      console.log('Resposta do Servidor:', response.data);
      alert('Usuário cadastrado com sucesso!');
      setFormData({ name: '', email: '', username: '', password: '' });
    } catch (error) {
      console.error('Erro ao cadastrar usuário:', error);
      alert('Erro ao cadastrar usuário. Tente novamente.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="h-screen w-80 fixed flex-col items-center justify-center bg-gray-300">
      <h2 className="text-2xl font-bold mb-4">Cadastrar Usuário</h2>
      <form
        onSubmit={handleSubmit}
        className="bg-white p-6 rounded shadow-md "
      >
        {/* Nome */}
        <div className="mb-4">
          <label htmlFor="name" className="block text-sm font-bold mb-2">
            Nome
          </label>
          <input
            type="text"
            id="name"
            name="name"
            value={formData.name}
            onChange={handleChange}
            placeholder="Digite o nome"
            className="w-full px-3 py-2 border rounded"
            required
          />
        </div>

        {/* Email */}
        <div className="mb-4">
          <label htmlFor="email" className="block text-sm font-bold mb-2">
            Email
          </label>
          <input
            type="email"
            id="email"
            name="email"
            value={formData.email}
            onChange={handleChange}
            placeholder="Digite o email"
            className="w-full px-3 py-2 border rounded"
            required
          />
        </div>

        {/* Nome de Usuário */}
        <div className="mb-4">
          <label htmlFor="username" className="block text-sm font-bold mb-2">
            Nome de Usuário
          </label>
          <input
            type="text"
            id="username"
            name="username"
            value={formData.username}
            onChange={handleChange}
            placeholder="Digite o nome de usuário"
            className="w-full px-3 py-2 border rounded"
            required
          />
        </div>

        {/* Senha */}
        <div className="mb-4">
          <label htmlFor="password" className="block text-sm font-bold mb-2">
            Senha
          </label>
          <input
            type="password"
            id="password"
            name="password"
            value={formData.password}
            onChange={handleChange}
            placeholder="Digite a senha"
            className="w-full px-3 py-2 border rounded"
            required
          />
        </div>

        {/* Botões */}
        <div className="flex justify-between">
          <button
            type="submit"
            className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            disabled={loading}
          >
            {loading ? 'Cadastrando...' : 'Cadastrar'}
          </button>
          <Link
            to="/"
            className="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400"
          >
            Voltar
          </Link>
        </div>
      </form>
    </div>
  );
}

export default CreateUser;
