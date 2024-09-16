<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

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

// Get URL from query parameters
$url = isset($_GET['url']) ? $_GET['url'] : null;

// Validate URL parameter
if (!$url) {
    echo json_encode(['label' => null]);
    $conn->close();
    exit();
}

// Prepare and execute query
$stmt = $conn->prepare('SELECT label FROM urls WHERE url = ?');
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param('s', $url);
$stmt->execute();
$stmt->bind_result($label);
$stmt->fetch();

$response = ['label' => $label !== null ? (int)$label : null];

$stmt->close();
$conn->close();

echo json_encode($response);

?>










