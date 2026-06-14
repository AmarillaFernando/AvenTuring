<?php
require_once __DIR__ . '/../config.php';
$host = env('DB_HOST');
$port = env('DB_PORT');
$dbname = env('DB_NAME');
$user = env('DB_USER');
$pass = env('DB_PASS');

try {

    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die($e->getMessage());

}