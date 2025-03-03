<?php
session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/Student.php';

// Ensure user is admin
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $student = new Student($db);
    $student->id = $_POST['id'];
    
    if ($student->delete()) {
        header('Location: ../index.php?page=students&success=deleted');
    } else {
        header('Location: ../index.php?page=students&error=delete_failed');
    }
    exit();
} else {
    header('Location: ../index.php?page=students');
    exit();
}
?>
