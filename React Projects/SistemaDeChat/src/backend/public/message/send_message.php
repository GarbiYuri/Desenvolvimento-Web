<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Cabeçalhos permitidos

require_once __DIR__ . '/../../src/databases/Connection.php';

$response = ['status' => 'success', 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Valida os campos obrigatórios
    if (!isset($data['user_id_send'], $data['user_id_get'], $data['message'])) {
        $response['message'] = 'Missing required fields';
        echo json_encode($response);
        exit;
    }

    try {
        $db = Connection::getConnection();
        $stmt = $db->prepare('
            INSERT INTO message (user_id_send, user_id_get, message)
            VALUES (:send, :get, :message)
        ');
        $stmt->execute([
           'send' => $data['user_id_send'],
            'get' => $data['user_id_get'],
            'message' => $data['message']
        ]);

        $response['status'] = 'success';
        $response['message'] = 'Message sent successfully';
    } catch (PDOException $e) {
        $response['message'] = 'Error storing message: ' . $e->getMessage();
    }
}

echo json_encode($response);
