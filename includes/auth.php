<?php
require_once __DIR__ . '/../config/database.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function login($email, $password) {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT id, email, password, role FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Debug password verification
        error_log("Attempting login for email: " . $email);
        error_log("Stored hash: " . $row['password']);
        error_log("Input matches hash: " . (password_verify($password, $row['password']) ? 'Yes' : 'No'));
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_role'] = $row['role'];
            error_log("Login successful for user: " . $row['email']);
            return true;
        }
        error_log("Password verification failed for user: " . $row['email']);
    } else {
        error_log("No user found with email: " . $email);
    }
    return false;
}

function logout() {
    session_destroy();
    header('Location: login.php');
    exit();
}

function requireAdmin() {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: index.php?error=unauthorized');
        exit();
    }
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT id, email, role FROM users WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $_SESSION['user_id']);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
