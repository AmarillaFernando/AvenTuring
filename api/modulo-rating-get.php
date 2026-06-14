<?php

require_once __DIR__ . '/../database/conexion.php';

header('Content-Type: application/json');

$modulo = $_GET['modulo'] ?? '';

if ($modulo === '') {
    echo json_encode(['promedio' => 0, 'total' => 0]);
    exit;
}

$stmt = $pdo->prepare(
    "SELECT ROUND(AVG(estrellas), 1) AS promedio, COUNT(*) AS total
     FROM modulo_ratings WHERE modulo_id = :modulo"
);
$stmt->execute([':modulo' => $modulo]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'promedio' => (float) ($data['promedio'] ?? 0),
    'total'    => (int)   ($data['total']    ?? 0),
]);