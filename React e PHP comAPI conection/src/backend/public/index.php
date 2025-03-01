<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Substitua pelo endereço correto do React
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


// Código de autenticação e lógica continua aqui
session_start();

// Define a sessão como deslogada no início
$_SESSION['is_logged_in'] = false;

// Inclui o controlador de usuário
require_once __DIR__ . '/../src/controllers/UsernameController.php';

$error = ''; // Variável para armazenar a mensagem de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodifica o JSON da requisição
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifica se 'username' e 'password' estão presentes
    $username = $data['username'] ?? null;
    $password = $data['password'] ?? null;

    if (!$username || !$password) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Username and password are required.'
        ]);
        exit;
    }

    // Cria um array para passar ao método loginUser
    $credentials = [
        'username' => $username,
        'passwords' => $password
    ];

    // Passa o array `credentials` ao método loginUser
    $controller = new UsernameController();
    $isAuthenticated = $controller->loginUser($credentials);

    if ($isAuthenticated) {
        $_SESSION['username'] = $username;
        $_SESSION['is_logged_in'] = true;

        echo json_encode([
            'status' => 'success',
            'message' => 'Login bem-sucedido'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid username or password.'
        ]);
    }
    exit;
}

