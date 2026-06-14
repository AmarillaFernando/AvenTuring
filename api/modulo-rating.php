<?php

require_once __DIR__ . '/../database/conexion.php';

header('Content-Type: application/json');

$modulo   = $_POST['modulo']   ?? '';
$estrellas= $_POST['estrellas'] ?? '';

if ($modulo === '' || $estrellas === '') {
    echo json_encode(['ok' => false]);
    exit;
}

$estrellas = (float) $estrellas;

if ($estrellas < 0.5 || $estrellas > 5) {
    echo json_encode(['ok' => false]);
    exit;
}

// Insertar el voto
$stmt = $pdo->prepare(
    "INSERT INTO modulo_ratings (modulo_id, estrellas) VALUES (:modulo, :estrellas)"
);
$stmt->execute([':modulo' => $modulo, ':estrellas' => $estrellas]);

// Devolver promedio actualizado y total de votos
$stmt = $pdo->prepare(
    "SELECT ROUND(AVG(estrellas), 1) AS promedio, COUNT(*) AS total
     FROM modulo_ratings WHERE modulo_id = :modulo"
);
$stmt->execute([':modulo' => $modulo]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'ok'       => true,
    'promedio' => (float) $data['promedio'],
    'total'    => (int)   $data['total'],
]);