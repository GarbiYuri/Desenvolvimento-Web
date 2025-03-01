<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$response = ['status' => 'success', 'message' => 'Logged out successfully'];

session_unset(); // Limpa todas as variáveis de sessão
session_destroy(); // Destroi a sessão

echo json_encode($response);
