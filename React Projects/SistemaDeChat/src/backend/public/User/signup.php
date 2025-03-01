<?php
// Configura o tipo de conteúdo da resposta para JSON
header("Content-Type: application/json");

// Permite que qualquer origem (frontend) faça requisições para este endpoint
header("Access-Control-Allow-Origin: *");

// Especifica que apenas requisições do tipo POST serão permitidas
header("Access-Control-Allow-Methods: POST");

// Define quais cabeçalhos podem ser enviados na requisição
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Inclui o arquivo do controlador UsernameController
require_once __DIR__ . '/../../src/controllers/UsernameController.php';

// Inicializa uma resposta padrão como erro
$response = ['status' => 'error', 'message' => 'Unknown error'];

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lê os dados do corpo da requisição e converte de JSON para um array PHP
    $data = json_decode(file_get_contents('php://input'), true);

    // Valida se os campos obrigatórios estão presentes no array $data
    if (!isset($data['name'], $data['username'],$data['email'],$data['password'])) {
        $response['message'] = 'Missing required fields'; // Mensagem de erro se algum campo está faltando
        echo json_encode($response); // Retorna a resposta como JSON
        exit; // Interrompe a execução do script
    }

    // Instancia o controlador para gerenciar os dados
    $controller = new UsernameController();

    // Chama o método createUsers do controlador, passando os dados necessários
    $result = $controller->createUsers([
      'name' =>  $data['name'],
      'username' => $data['username'],
      'email' =>  $data['email'],
       'password' => $data['password']
    ]);

    // Analisa o resultado do controlador e atualiza a resposta
    if ($result === true) {
        $response['status'] = 'success'; // Indica sucesso
        $response['message'] = 'User created successfully'; // Mensagem de sucesso
    } elseif ($result === 'exists') {
        $response['message'] = 'Username already exists'; // Mensagem de erro se o usuário já existe
    } else {
        $response['message'] = 'Error creating user'; // Mensagem de erro genérico
    }
}

// Converte a resposta final para JSON e a envia para o cliente (frontend)
echo json_encode($response);
