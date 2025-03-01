<?php
session_start();

// Regenera o ID da sessão para evitar ataques de fixação de sessão
session_regenerate_id(true);
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Origin: http://localhost:5173");  // Configura o CORS corretamente
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$response = ['status' => 'error', 'message' => 'Not logged in'];

// Verifica se o usuário está logado
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    // Se estiver logado, retorna o status de sucesso e os dados do usuário
    $response['status'] = 'success';
    $response['user'] = $_SESSION['user'];
    $response['message'] = 'Not logged in';
}

echo json_encode($response);
