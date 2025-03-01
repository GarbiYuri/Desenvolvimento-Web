<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/../../src/databases/Connection.php';

// Inicializa a resposta padrão
$response = ['status' => 'error', 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtém os parâmetros da query string
    $userIdSend = $_GET['user_id_send'] ?? null;
    $userIdGet = $_GET['user_id_get'] ?? null;

    if (!$userIdSend || !$userIdGet) {
        $response['message'] = 'Missing user ID';
        echo json_encode($response);
        exit;
    }

    try {
        $db = Connection::getConnection();

        // Consulta para buscar as mensagens enviadas e recebidas entre os dois usuários
        $stmt = $db->prepare('
            SELECT * 
            FROM message 
            WHERE 
                (user_id_send = :user_id_send AND user_id_get = :user_id_get)
                OR (user_id_send = :user_id_get AND user_id_get = :user_id_send)
            ORDER BY message_id ASC
        ');

        $stmt->execute([
            'user_id_send' => $userIdSend,
            'user_id_get' => $userIdGet,
        ]);

        // Busca todas as mensagens
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['status'] = 'success';
        $response['data'] = $messages;
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
}

echo json_encode($response);
