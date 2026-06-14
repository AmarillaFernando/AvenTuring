<?php

require_once __DIR__ . '/../database/conexion.php';

header('Content-Type: application/json');

$modulo = $_POST['modulo'] ?? '';

if ($modulo === '') {
    echo json_encode(['ok' => false]);
    exit;
}

$stmt = $pdo->prepare("UPDATE modulos SET vistas = vistas + 1 WHERE id = :id");
$stmt->execute([':id' => $modulo]);

echo json_encode(['ok' => true]);