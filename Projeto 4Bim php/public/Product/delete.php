<?php
// public/delete.php

session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/ProductController.php';

if (isset($_GET['id'])) {
    $controller = new ProductController();
    $controller->deleteProduct($_GET['id']);
}

header('Location: ../User/list.php');
exit;
