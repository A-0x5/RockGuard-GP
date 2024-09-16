<?php
// Database configuration
$host = 'localhost';
$db = 'rock_guard';
$user = 'root';
$pass = '';

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Path to your JSON file
$jsonFilePath = 'assets/dataset.json';

// Check if the JSON file exists
if (!file_exists($jsonFilePath)) {
    die('JSON file not found');
}

// Read and decode JSON data
$jsonData = file_get_contents($jsonFilePath);
$data = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Invalid JSON data');
}

// Prepare and execute query
$stmt = $conn->prepare('INSERT INTO urls (url, label) VALUES (?, ?)');
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}

foreach ($data as $item) {
    $stmt->bind_param('si', $item['url'], $item['label']);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo 'Data imported successfully';
?>
