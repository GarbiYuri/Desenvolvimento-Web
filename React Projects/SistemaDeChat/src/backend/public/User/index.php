<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/../../src/controllers/UsernameController.php';

$response = ['status' => 'error', 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['username'], $data['password'])) {
        $response['message'] = 'Missing required fields';
        echo json_encode($response);
        exit;
    }

    $controller = new UsernameController();
    $result = $controller->loginUser([
        'username' => $data['username'], 
        'password' => $data['password']]);

    if ($result != false) {
         // Armazena o estado de login na sessão
         $_SESSION['is_logged_in'] = true;
         $_SESSION['user'] = [
             'id' => $result['id'],
             'username' => $result['username'],
             'name' => $result['name'],
             'email' => $result['email']
         ];
        $response['status'] = 'success';
        $response['message'] = 'Logged in successfully';
        $response['user'] = [
            'id' => $result['id'],  // ID do usuário
            'username' => $result['username']  // Nome do usuário
        ];
    } else {
        $response['message'] = 'Invalid username or password';
    }
}

echo json_encode($response);
