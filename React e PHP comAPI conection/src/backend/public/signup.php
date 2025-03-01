<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Endereço do front-end
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

session_start();

require_once __DIR__ . '/../src/controllers/UsernameController.php';

$response = ['status' => 'error', 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);


    if (!isset($data['username']) || !isset($data['passwords'])) {
        $response['message'] = 'Username and password are required';
    } else {
        $controller = new UsernameController();
        $isCreated = $controller->createUsers($data);

        if ($isCreated) {
            $response = [
                'status' => 'success',
                'message' => 'User registered successfully'
            ];
        } else {
            $response['message'] = 'Failed to register user';
        }
    }
}

echo json_encode($response);
exit;
