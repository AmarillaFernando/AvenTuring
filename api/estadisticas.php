<?php

require_once __DIR__ . '/../database/conexion.php';

header('Content-Type: application/json');

$tipo   = $_GET['tipo']    ?? '';
$excluir = $_GET['excluir'] ?? '';

switch ($tipo) {

    // Top 3 más vistos — si no hay suficientes con visitas, completa con aleatorios
    case 'populares':
        $params = [];
        $limit  = max(1, intval($_GET['limit'] ?? 3));

        $where = $excluir ? "WHERE m.id != :excluir" : "";
        if ($excluir) $params[':excluir'] = $excluir;

        // Primero los que tienen visitas
        $sql = "SELECT m.id, m.nombre, m.vistas,
                       ROUND(AVG(r.estrellas), 1) AS promedio,
                       COUNT(r.id) AS votos
                FROM modulos m
                LEFT JOIN modulo_ratings r ON r.modulo_id = m.id
                $where
                GROUP BY m.id, m.nombre, m.vistas
                ORDER BY m.vistas DESC, RAND()
                LIMIT {$limit}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si hay menos de 3, completar con aleatorios que no estén ya
        if (count($rows) < $limit) {
            $yaIncluidos = array_column($rows, 'id');
            if ($excluir) $yaIncluidos[] = $excluir;

            $placeholders = implode(',', array_fill(0, count($yaIncluidos), '?'));
            $faltantes = $limit - count($rows);

            $sqlExtra = "SELECT m.id, m.nombre, m.vistas,
                                ROUND(AVG(r.estrellas), 1) AS promedio,
                                COUNT(r.id) AS votos
                         FROM modulos m
                         LEFT JOIN modulo_ratings r ON r.modulo_id = m.id
                         WHERE m.id NOT IN ($placeholders)
                         GROUP BY m.id, m.nombre, m.vistas
                         ORDER BY RAND()
                         LIMIT $faltantes";

            $stmtExtra = $pdo->prepare($sqlExtra);
            $stmtExtra->execute($yaIncluidos);
            $rows = array_merge($rows, $stmtExtra->fetchAll(PDO::FETCH_ASSOC));
        }

        echo json_encode($rows);
        break;

    // Top 3 mejor valorados
    case 'valorados':
        $limit  = max(1, intval($_GET['limit'] ?? 3));
        $params = [];
        $where  = $excluir ? "WHERE m.id != :excluir" : "";
        if ($excluir) $params[':excluir'] = $excluir;

        $sql = "SELECT m.id, m.nombre, m.vistas,
                       ROUND(AVG(r.estrellas), 1) AS promedio,
                       COUNT(r.id) AS votos
                FROM modulos m
                INNER JOIN modulo_ratings r ON r.modulo_id = m.id
                $where
                GROUP BY m.id, m.nombre, m.vistas
                HAVING COUNT(r.id) > 0
                ORDER BY promedio DESC, votos DESC LIMIT {$limit}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si no hay valorados, mostrar aleatorios
        if (empty($rows)) {
            $params2 = [];
            $where2  = $excluir ? "WHERE m.id != :excluir" : "";
            if ($excluir) $params2[':excluir'] = $excluir;

            $sqlRand = "SELECT m.id, m.nombre, m.vistas, NULL AS promedio, 0 AS votos
                        FROM modulos m $where2
                        ORDER BY RAND() LIMIT {$limit}";
            $stmtRand = $pdo->prepare($sqlRand);
            $stmtRand->execute($params2);
            $rows = $stmtRand->fetchAll(PDO::FETCH_ASSOC);
        }

        echo json_encode($rows);
        break;

    default:
        echo json_encode([]);
}