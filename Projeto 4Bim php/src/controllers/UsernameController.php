<?php
// src/controllers/UsernameController.php

require_once __DIR__ . '/../models/Usuario.php';

class UsernameController
{
    public function listUsers()
    {
        return Usuario::getAll();
    }

    public function loginUser($data)
    {
        return Usuario::verifyUser($data);
    }

    public function createUsers($data)
{
    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($data['username']) || empty($data['passwords'])) {
        throw new Exception('All fields are required.');
    }


    // Chama o método estático para criar o usuário
    Usuario::create($data);
}


    public function editUsers($id, $data)
    {
        Usuario::update($id, $data);
    }

    public function deleteUsers($username)
    {
        Usuario::delete($username);
    }
}