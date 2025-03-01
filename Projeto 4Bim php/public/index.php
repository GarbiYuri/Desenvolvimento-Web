<?php
session_start();


// Redireciona para `list.php` se o usuário já estiver logado
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: User/list.php');
    exit;
}

// Define a sessão como deslogada no início
$_SESSION['is_logged_in'] = false;

// Inclui o controlador de usuário
require_once __DIR__ . '/../src/controllers/UsernameController.php';

$error = ''; // Variável para armazenar a mensagem de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsernameController();
    $isAuthenticated = $controller->loginUser($_POST);

    if ($isAuthenticated) {
        // Define o usuário de sessão e marca como logado antes do redirecionamento
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['is_logged_in'] = true;
        
        // Redireciona para `list.php` se o login for bem-sucedido
        header('Location: User/list.php');
        exit; // Encerra a execução após o redirecionamento
    } else {
        // Define a mensagem de erro se o login falhar
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800">Sign In</h2>
        
        <!-- Exibe a mensagem de erro, se houver -->
        <?php if ($error): ?>
            <p class="text-red-500 text-center"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="index.php" method="POST" class="space-y-6">
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input id="username" name="username" type="text" required 
                    class="w-full px-4 py-2 mt-1 text-gray-900 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Enter your username">
            </div>
            <!-- Password -->
            <div>
                <label for="passwords" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="passwords" name="passwords" type="password" required 
                    class="w-full px-4 py-2 mt-1 text-gray-900 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Enter your password">
            </div>
            <!-- Submit Button -->
            <div>
                <button type="submit" 
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    Sign In
                </button>
            </div>
        </form>
        <!-- Sign Up Link -->
        <div class="text-sm text-center text-gray-600">
            <p>Don't have an account? 
                <a href="User/signup.php" class="font-medium text-blue-600 hover:text-blue-500">Sign Up</a>
            </p>
        </div>
    </div>
</body>
</html>
