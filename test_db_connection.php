<?php
$host = 'localhost';
$db = 'rock_guard';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful.";
} catch (PDOException $e) {
    echo 'Database connection error: ' . $e->getMessage();
}
?>
