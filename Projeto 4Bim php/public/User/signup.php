<?php
// src/views/signup.php

// Define a sessão como false para USuario existente falsa no Inicio
$_SESSION['is_true'] = 0;
/* 
 0 = Normal
 1 = Usuario ja Existe
 2 = Senhas não conicidem
 */

$error = '';

require_once __DIR__ . '/../../src/controllers/UsernameController.php';

// Redireciona para `list.php` se o usuário já estiver logado
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: User/list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsernameController();
    $controller->createUsers($_POST);
    
    switch($_SESSION['is_true']){
        case 0:
            header('Location: ../index.php');
            break;
        case 1:
            $error = "Username already exists";
            break;
            case 2:
                $error = "Passwords do not match";
                break;
            
    }
    
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800">Sign Up</h2>
        <?php if (!empty($error)): ?>
            <div class="mb-4 text-red-600 text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form action="signup.php" method="POST" class="space-y-6">
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input id="username" name="username" type="text" required 
                    class="w-full px-4 py-2 mt-1 text-gray-900 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Choose a username">
            </div>
            <!-- Password -->
            <div>
                <label for="passwords" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="passwords" name="passwords" type="password" required 
                    class="w-full px-4 py-2 mt-1 text-gray-900 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Create a password">
            </div>
             <!-- Confirm Password -->
             <div>
                <label for="confirm_passwords" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="confirm_passwords" name="confirm_passwords" type="password" required 
                    class="w-full px-4 py-2 mt-1 text-gray-900 placeholder-gray-400 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Confirm your password">
            </div>
            <!-- Submit Button -->
            <div>
                <button type="submit" 
                    class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    Sign Up
                </button>
            </div>
        </form>
        <!-- Already Have an Account -->
        <div class="text-sm text-center text-gray-600">
            <p>Already have an account? 
                <a href="../index.php" class="font-medium text-blue-600 hover:text-blue-500">Sign In</a>
            </p>
        </div>
    </div>
</body>
</html>
