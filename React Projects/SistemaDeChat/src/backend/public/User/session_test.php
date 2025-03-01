<?php
session_start();

if (!isset($_SESSION['test'])) {
    $_SESSION['test'] = 'Session is working!';
} else {
    echo "Session value: " . $_SESSION['test'];
}
?>
