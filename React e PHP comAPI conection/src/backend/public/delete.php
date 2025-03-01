<?php
// public/delete.php

require_once __DIR__ . '/../src/controllers/UsernameController.php';

if (isset($_GET['id'])) {
    $controller = new UsernameController();
    $controller->deleteUsers($_GET['id']);
}



header('Location: logout.php');
exit;
