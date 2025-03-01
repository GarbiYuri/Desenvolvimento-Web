<?php
// public/delete.php

session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/UsernameController.php';

if (isset($_GET['id'])) {
    $controller = new UsernameController();
    $controller->deleteUsers($_GET['id']);
}



header('Location: logout.php');
exit;
