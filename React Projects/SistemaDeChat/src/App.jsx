import { BrowserRouter, Routes, Route, Link } from 'react-router-dom';
import { useState, useEffect } from 'react';
import axios from 'axios';
import CreateUser from './components/CreateUser';
import Login from './components/Login';
import './App.css';

function App() {
  const [users, setUsers] = useState([]); // Lista dinâmica de usuários
  const [selectedPerson, setSelectedPerson] = useState(null); // Usuário selecionado
  const [messages, setMessages] = useState([]); // Lista de mensagens
  const [message, setMessage] = useState(''); // Mensagem a ser enviada
  const [error, setError] = useState(''); // Mensagem de erro ao buscar usuários
  const [isLoggedIn, setIsLoggedIn] = useState(false); // Estado de autenticação
  const [loggedInUser, setLoggedInUser] = useState(''); // Nome de usuário logado
  const [loggedInUserId, setLoggedInUserId] = useState(null); // ID do usuário logado


   // Verificação de sessão ao carregar o componente
   useEffect(() => {
    const checkSession = async () => {
      try {
        const response = await axios.get('http://localhost:8000/public/User/check_session.php');
        if (response.data.status === 'success') {
          handleLogin(response.data.user); // Define os dados do usuário logado
        }
        console.log(response.data);
        console.log(response.data.status);
        console.log(response.data.message)
      } catch (err) {
        console.error('Erro ao verificar sessão:', err);
      }
    };

    checkSession();
  }, []);

  // Função para buscar usuários do backend
  const fetchUsers = async () => {
    try {
      const response = await axios.get('http://localhost:8000/public/User/list.php');
      if (response.data.status === 'success') {
        const filteredUsers = response.data.data.filter(user => user.username !== loggedInUser);
        setUsers(filteredUsers); // Atualiza a lista de usuários
      } else {
        setError(response.data.message || 'Erro ao carregar usuários');
      }
    } catch (err) {
      setError('Erro ao conectar ao servidor');
      console.error(err);
    }
  };
 // Função para enviar mensagem
 const sendMessage = async () => {
  if (!message.trim()) return;

  try {
    const response = await axios.post('http://localhost:8000/public/message/send_message.php', {
      user_id_send: loggedInUserId,
      user_id_get: selectedPerson.id,
      message,
    });
  // Verifique se o response está sendo recebido corretamente
  console.log('userId:', loggedInUser);
console.log('recipientId:', selectedPerson.id);
  console.log('Resposta do servidor:', response.data);
    if (response.data.status === 'success') {
      setMessages([...messages, { user_id_send: loggedInUserId, user_id_get: selectedPerson, message }]);
      setMessage(''); // Limpa o campo de mensagem
    } else {
      console.log(response.data.teste)
      console.error('Erro ao enviar mensagem:', response.data.message);
    }
  } catch (err) {
    console.error('Erro de conexão:', err);
  }
};
  // Função para carregar mensagens entre o usuário logado e o selecionado
  const fetchMessages = async () => {
    if (!selectedPerson) return;

    try {
      const response = await axios.get(
        `http://localhost:8000/public/message/get_messages.php?user_id_send=${loggedInUserId}&user_id_get=${selectedPerson.id}`
      );
      if (response.data.status === 'success') {
        setMessages(response.data.data); // Atualiza a lista de mensagens
      } else {
        console.error('Erro ao carregar mensagens:', response.data.message);
      }
    } catch (err) {
      console.error('Erro ao conectar ao servidor:', err);
    }
  };

  // Atualização periódica de mensagens
  useEffect(() => {
    let interval;

    if (selectedPerson) {
      fetchMessages(); // Carrega mensagens imediatamente
      interval = setInterval(fetchMessages, 3000); // Atualiza a cada 3 segundos
    }

    return () => {
      if (interval) clearInterval(interval); // Limpa o intervalo ao desmontar
    };
  }, [selectedPerson, loggedInUserId]);

 

  // Carregar usuários quando o estado de login muda
  useEffect(() => {
    if (isLoggedIn) {
      fetchUsers();
    }
  }, [isLoggedIn, loggedInUser]);

  // Função para selecionar um usuário para o chat
  const openChat = (person) => {
    setSelectedPerson(person);
    setMessages([]); // Limpa mensagens ao trocar de chat
  };

  // Função para login
  const handleLogin = (username, userId) => {
    setIsLoggedIn(true);
    setLoggedInUser(username); // Salva o nome do usuário logado
    setLoggedInUserId(userId); // Salva o ID do usuário logado
  };

  // Função para logout
  const handleLogout = async () => {
    try {
      const response = await axios.post('http://localhost:8000/public/User/logout.php');
      if (response.data.status === 'success') {
        setIsLoggedIn(false);
        setLoggedInUser('');
        setLoggedInUserId(null);
        setSelectedPerson(null);
      }
    } catch (err) {
      console.error('Erro ao fazer logout:', err);
    }
  };

  return (
    <BrowserRouter>
      <div className="flex h-screen">
        {/* Sidebar */}
        <div className="w-1/4 bg-blue-500 p-4 overflow-y-auto">
          <h2 className="text-lg text-center font-bold mb-4 text-white">Menu</h2>
          <h3 className="text-lg text-center font-bold mb-4 text-white">Logado como {loggedInUser}</h3>
          {!isLoggedIn ? (
            <>
              {/* Botão de Login */}
              <Link
                to="user/login"
                className="block text-center mt-4 bg-blue-700 hover:bg-blue-900 text-white py-2 rounded"
              >
                Login
              </Link>
              {/* Botão de Cadastrar */}
              <Link
                to="user/create"
                className="block text-center mt-4 bg-blue-700 hover:bg-blue-900 text-white py-2 rounded"
              >
                Cadastrar Usuário
              </Link>
            </>
          ) : (
            <>
              {/* Lista de Usuários */}
              <h2 className="text-lg text-center font-bold mb-4 text-white">Usuários</h2>
              {error && <p className="text-red-500 text-center">{error}</p>}
              {users.map((user) => (
                <button
                  key={user.id}
                  onClick={() => openChat(user)}
                  className="w-full text-left bg-gray-200 hover:bg-gray-300 p-2 rounded mb-2"
                >
                  {user.name} ({user.username})
                </button>
              ))}
              {/* Botão de Logout */}
              <button
                onClick={handleLogout}
                className="block text-center mt-4 bg-red-500 hover:bg-red-700 text-white py-2 rounded"
              >
                Logout
              </button>
            </>
          )}
        </div>

        {/* Main Content */}
        <div className="w-3/4 bg-white p-4">
          {!isLoggedIn ? (
            <Routes>
              <Route path="user/login" element={<Login onLogin={handleLogin} />} />
              <Route path="user/create" element={<CreateUser />} />
              <Route path="*" element={<div className="p-4">Faça login ou cadastre-se.</div>} />
            </Routes>
          ) : selectedPerson ? (
            <>
              <h2 className="text-lg font-bold mb-4">Chat com {selectedPerson.name}</h2>
              <div className="flex-grow border p-2 rounded overflow-y-auto bg-gray-50">
                {messages.map((msg, index) => (
                  <p
                    key={index}
                    className={msg.user_id_send === loggedInUserId ? 'text-right text-blue-600' : 'text-left text-green-600'}
                  >
                    {msg.message}
                  </p>
                ))}
              </div>
              <div>
    

      <div className="mt-4 flex items-center">
        <input
          type="text"
          value={message}
          onChange={(e) => setMessage(e.target.value)}
          placeholder="Digite sua mensagem..."
          className="flex-grow border p-2 rounded-l"
        />
        <button
          onClick={sendMessage}
          className="bg-blue-500 text-white px-4 py-2 rounded-r"
        >
          
          Enviar
        </button>
      </div>
    </div>
            </>
          ) : (
            <div className="text-gray-500 flex-grow flex items-center justify-center">
              Selecione um usuário para iniciar o chat.
            </div>
          )}
        </div>
      </div>
    </BrowserRouter>
  );
}

export default App;
