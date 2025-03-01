<?php

require_once __DIR__ . '/../../src/controllers/ProductController.php';

session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

$username = htmlspecialchars($_SESSION['username']);

$controller = new ProductController();
$products = $controller->listProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-600 text-white flex flex-col p-4">
            <h2 class="text-2xl font-bold mb-6">My Dashboard</h2>
            <nav class="flex flex-col space-y-4">
                <a href="edit.php" class="hover:bg-blue-500 p-2 rounded">Profile</a>
                <a href="../Product/create.php" class="hover:bg-blue-500 p-2 rounded">Create Product</a>
                <a href="logout.php" class="hover:bg-red-500 p-2 rounded">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-semibold">Welcome, <?php echo $username; ?>!</h1>
            </header>

            <!-- Product Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full bg-white">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Description</th>
                            <th class="py-3 px-6 text-left">Price</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach ($products as $product): ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-6"><?= htmlspecialchars($product['name']) ?></td>
                                <td class="py-3 px-6"><?= htmlspecialchars($product['description']) ?></td>
                                <td class="py-3 px-6"><?= htmlspecialchars($product['price']) ?></td>
                                <td class="py-3 px-6 flex space-x-2">
                                    <a href="../Product/edit.php?id=<?= htmlspecialchars($product['id']) ?>" 
                                       class="text-blue-600 hover:underline">Editar</a>
                                    <a href="../Product/delete.php?id=<?= htmlspecialchars($product['id']) ?>" 
                                       class="text-red-600 hover:underline"
                                       onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

