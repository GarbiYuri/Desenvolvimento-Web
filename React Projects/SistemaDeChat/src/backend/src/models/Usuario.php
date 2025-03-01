<?php
// src/models/Product.php

require_once __DIR__ . '/../databases/Connection.php';

class Usuario
{
    public static function getAll()
    {
        $db = Connection::getConnection();
        $stmt = $db->query('SELECT * FROM usuario');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function verifyUser($data)
{
    
        $db = Connection::getConnection();
    
        // Consulta o usuário pelo username
        $stmt = $db->prepare('SELECT * FROM usuario WHERE username = :username');
        $stmt->execute(['username' => $data['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verifica se o usuário existe e se a senha está correta
        if ($user && password_verify($data['password'], $user['password'])) {

            return $user; // Retorna true se a autenticação for bem-sucedida
        } else {
            return false; // Retorna false se falhar
        }
}
    

    
public static function create($data)
{
    
    $db = Connection::getConnection();

    $stmt = $db->prepare('INSERT INTO usuario (name, username, email, password ) VALUES (:name, :username, :email, :password)');
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt->execute([
        'name' => $data['name'],
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => $hashedPassword
    ]);

    return true;
}


    public static function update($id, $data)
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['username'])) {
            return false; // Retorna falso se o `username` não estiver na sessão
        }
    
        // Conexão com o banco de dados
        $db = Connection::getConnection();
    
        // Verifica se o novo `username` já existe para outro usuário
        $stmt = $db->prepare('SELECT * FROM usuario WHERE username = :newusername AND id != :id');
        $stmt->execute([
            'newusername' => $data['username'],
            'id' => $id,
        ]);
    
        // Se encontrar um usuário com o mesmo `username`, retorna `false`
        if ($stmt->fetch()) {
            return false; // Retorna falso se o novo `username` já estiver em uso
        }
    
        // Atualiza o `username` e a `password`, se uma nova senha for fornecida
        if (!empty($data['passwords'])) {
            // Hasheia a nova senha
            $hashedPassword = password_hash($data['passwords'], PASSWORD_DEFAULT);
    
            // Prepara a consulta de atualização com `username` e `passwords`
            $stmt = $db->prepare('UPDATE usuario SET username = :username, passwords = :passwords WHERE id = :id');
            $stmt->execute([
                'username' => $data['username'],
                'passwords' => $hashedPassword,
                'id' => $id,
            ]);
    
            // Atualiza o `username` na sessão após a atualização bem-sucedida
            $_SESSION['username'] = $data['username'];
    
            return true; // Retorna true indicando sucesso
        } else {
            // Atualiza apenas o `username` se a senha não for fornecida
            $stmt = $db->prepare('UPDATE usuario SET username = :username WHERE id = :id');
            $stmt->execute([
                'username' => $data['username'],
                'id' => $id,
            ]);
    
            // Atualiza o `username` na sessão após a atualização bem-sucedida
            $_SESSION['username'] = $data['username'];
    
            return true; // Retorna true indicando sucesso
        }
    }
    

    public static function delete($id)
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare('DELETE FROM usuario WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}