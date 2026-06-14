<?php

require_once __DIR__ . '/../database/conexion.php';

header('Content-Type: application/json');

$software  = $pdo->query("SELECT COUNT(*) FROM softwares")->fetchColumn();
$modulos   = $pdo->query("SELECT COUNT(*) FROM modulos")->fetchColumn();
$comentarios = $pdo->query("SELECT COUNT(*) FROM comentarios")->fetchColumn();

echo json_encode([
    'software'    => (int) $software,
    'modulos'     => (int) $modulos,
    'comentarios' => (int) $comentarios,
]);