<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/Student.php';

// Check if user is logged in
if (!isLoggedIn() && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Management - Northern University Bangladesh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
   
    
</head>
<body>
    <?php if (isLoggedIn()): ?>
        <?php include 'includes/navbar.php'; ?>
    <?php endif; ?>

    <div class="container mt-4">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $allowedPages = ['dashboard', 'students', 'add-student', 'edit-student', 'profile'];
        
        if (in_array($page, $allowedPages)) {
            include "pages/$page.php";
        } else {
            include "pages/404.php";
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
