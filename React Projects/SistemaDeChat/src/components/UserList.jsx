import { useEffect, useState } from 'react';
import axios from 'axios';

function UserList() {
  const [users, setUsers] = useState([]);
  const [error, setError] = useState('');

  useEffect(() => {
    // Chama a API para listar os usuários
    const fetchUsers = async () => {
      try {
        const response = await axios.get('http://localhost:8000/public/User/list.php');
        if (response.data.status === 'success') {
          setUsers(response.data.data);
        } else {
          setError(response.data.message || 'Failed to load users');
        }
      } catch (err) {
        setError('Error connecting to server');
        console.error(err);
      }
    };

    fetchUsers();
  }, []);

  return (
    <div>
      <h2>Usuários Cadastrados</h2>
      {error && <p style={{ color: 'red' }}>{error}</p>}
      <ul>
        {users.map((user) => (
          <li key={user.id}>
            {user.name} ({user.username}) - {user.email}
          </li>
        ))}
      </ul>
    </div>
  );
}

export default UserList;
