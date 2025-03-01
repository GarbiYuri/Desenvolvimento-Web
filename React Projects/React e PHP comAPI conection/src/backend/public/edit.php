<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Substitua pelo endereço correto do React
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
session_start();
$result = '';

require_once __DIR__ . '/../src/controllers/UsernameController.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Define o username e o ID do usuário logado
$username = htmlspecialchars($_SESSION['username']);
$id = $_SESSION['id']; // Obtém o ID do usuário da sessão

// Processa o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se as variáveis de senha estão definidas
    if (isset($_POST['passwords'], $_POST['confirm_password'])) {
        // Verifica se as senhas coincidem antes de chamar o controlador
        if ($_POST['passwords'] === $_POST['confirm_password']) {
            $controller = new UsernameController();
            $controller->editUsers($id, $_POST);
            $username = $_SESSION['username'];
}else{
    $result = "Passwords Don't match";
}
}
}
?>
