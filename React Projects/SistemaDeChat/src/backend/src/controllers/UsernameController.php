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

    public function createUsers($data) {
        $user = new Usuario();

        // Criar o usuário
        return $user->create($data);
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