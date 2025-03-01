<?php
session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
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
                <a href="logout.php" class="hover:bg-red-500 p-2 rounded">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-semibold">Welcome, <?php echo $username; ?>!</h1>
            </header>
</body>
</html>
