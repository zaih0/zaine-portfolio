<?php
$host = "localhost";       // or your Plesk host
$dbname = "portfolio_db";     // database name
$username = "admin";        // DB username
$password = "admin";            // DB password (set this in Plesk)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
