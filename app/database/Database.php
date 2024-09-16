<?php

namespace RockGuard\app\database;

use PDO;
use PDOException;


$dns    = 'mysql:host=127.0.0.1:3306;dbname=rock_guard';
$user   = 'root';
$pass   = '';

$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
];

try {
    $conn = new PDO($dns, $user, $pass, $options);
    return $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    die($e->getMessage());
}
