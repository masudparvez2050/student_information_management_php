<?php
require_once __DIR__ . '/config/database.php';

$email = 'admin@nub.ac.bd';
$password = 'admin123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // First try to delete existing admin user
    $delete = "DELETE FROM users WHERE email = :email";
    $stmt = $db->prepare($delete);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    // Insert new admin user with fresh password hash
    $insert = "INSERT INTO users (email, password, role) VALUES (:email, :password, 'admin')";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashedPassword);
    $stmt->execute();
    
    echo "Admin user reset successfully!\n";
    echo "Email: " . $email . "\n";
    echo "Password: " . $password . "\n";
    echo "Hash: " . $hashedPassword . "\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
