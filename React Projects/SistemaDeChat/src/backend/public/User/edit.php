<?php
session_start();

$result = '';

require_once __DIR__ . '/../../src/controllers/UsernameController.php';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-600 text-white flex flex-col p-4">
            <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
            <nav class="flex flex-col space-y-4">
                <a href="list.php" class="hover:bg-blue-500 p-2 rounded">Home</a>
                <a href="../Product/create.php" class="hover:bg-blue-500 p-2 rounded">Create Product</a>
                <a href="logout.php" class="hover:bg-red-500 p-2 rounded">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">


            <!-- Edit Profile Form -->
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
            <form action="edit.php" method="POST" class="space-y-6">

    <!-- New Username -->
    <div>
        <label for="username" class="block text-sm font-medium text-gray-700">New Username</label>
        <input id="username" name="username" type="text" 
            class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter your new username" value="<?php echo $username; ?>" required>
    </div>

    <!-- New Password -->
    <div>
        <label for="passwords" class="block text-sm font-medium text-gray-700">New Password</label>
        <input id="passwords" name="passwords" type="password"
            class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter a new password">
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
        <input id="confirm_password" name="confirm_password" type="password"
            class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
            placeholder="Confirm your new password">
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
            Save Changes
        </button>
    
</form>
<a href="delete.php?id=<?= $id ?>" 
                    onclick="return confirm('Tem certeza que deseja excluir este produto?')"
                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-blue-300">
                    Excluir</a>
                    </div>
                <!-- Exibe a mensagem de erro ou sucesso, se houver -->
                <?php if (!empty($result)): ?>
                    <p class="<?php 'text-red-500'; ?> text-center mt-4">
                        <?php echo $result; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
