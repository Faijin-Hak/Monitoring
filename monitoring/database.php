<?php
// database.php - Improved version with auto database creation
$host = 'localhost';
$username = 'root';
$password = ''; // Leave empty for XAMPP, change if may password

try {
    // First connect without database
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS funded_projects");
    $pdo->exec("USE funded_projects");
    
    // Create table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        year_approved INT NOT NULL,
        beneficiary VARCHAR(255) NOT NULL,
        contact_person VARCHAR(255) NOT NULL,
        fund_amount DECIMAL(15,2) NOT NULL,
        email VARCHAR(255) NOT NULL,
        contact_details VARCHAR(100) NOT NULL,
        address TEXT NOT NULL,
        city_municipality VARCHAR(255) NOT NULL,
        district VARCHAR(50) NOT NULL,
        priority_sector VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>