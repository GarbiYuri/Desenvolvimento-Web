import { useState } from 'react';
import axios from 'axios';

function Chat({ userId, recipientId, onSendMessage }) {
  const [message, setMessage] = useState('');
  const [messages, setMessages] = useState([]); // Lista de mensagens carregadas

  // Função para enviar mensagem
  const sendMessage = async () => {
    if (!message.trim()) return;

    try {
      const response = await axios.post('http://localhost:8000/public/message/send_message.php', {
        user_id_send: userId,
        user_id_get: recipientId,
        message,
      });

      if (response.data.status === 'success') {
        setMessages([...messages, { user_id_send: userId, user_id_get: recipientId, message }]);
        setMessage(''); // Limpa o campo de mensagem
      } else {
        console.error('Erro ao enviar mensagem:', response.data.message);
      }
    } catch (err) {
      console.error('Erro de conexão:', err);
    }
  };

  // Função para carregar mensagens
  const fetchMessages = async () => {
    try {
      const response = await axios.get(`http://localhost:8000/public/User/get_messages.php?user_id=${userId}`);
      if (response.data.status === 'success') {
        setMessages(response.data.data); // Atualiza a lista de mensagens
      } else {
        console.error('Erro ao carregar mensagens:', response.data.message);
      }
    } catch (err) {
      console.error('Erro de conexão:', err);
    }
  };

  // Carrega mensagens ao iniciar o componente
  useEffect(() => {
    fetchMessages();
  }, []);
   
}

export default Chat;
