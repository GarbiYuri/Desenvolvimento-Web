<?php
// src/views/edit.php

session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/ProductController.php';

$controller = new ProductController();

if (!isset($_GET['id'])) {
    header('Location: ../User/list.php');
    exit;
}

$product = $controller->viewProduct($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->editProduct($_GET['id'], $_POST);
    header('Location: ../User/list.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex">
    <!-- Sidebar -->
    <div class="w-64 bg-blue-600 text-white flex flex-col p-4">
        <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
        <nav class="flex flex-col space-y-4">
            <a href="../User/list.php" class="hover:bg-blue-500 p-2 rounded">Home</a>
            <a href="../User/edit.php" class="hover:bg-blue-500 p-2 rounded">Profile</a>
            <a href="create.php" class="hover:bg-blue-500 p-2 rounded">Create Product</a>
            <a href="../User/logout.php" class="hover:bg-red-500 p-2 rounded">Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-semibold mb-4">Editar Produto</h1>
            <form action="edit.php?id=<?= htmlspecialchars($product['id']) ?>" method="post" class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-700">Nome:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label for="description" class="block text-gray-700">Descrição:</label>
                    <textarea id="description" name="description" 
                              class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                <div>
                    <label for="price" class="block text-gray-700">Preço:</label>
                    <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="flex justify-end space-x-4">
                    <a href="../User/list.php" class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Voltar à Lista</a>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>



