<?php
session_start();
require_once 'includes/auth.php';

if (isLoggedIn()) {
    logout();
} else {
    header('Location: login.php');
    exit();
}
?>
