<?php

require_once __DIR__ . '/../database/conexion.php';

$id = $_POST['id'] ?? 0;
$vote = $_POST['vote'] ?? '';
$prev = $_POST['prev'] ?? '';

if (!$id || !in_array($vote, ['like', 'dislike'], true)) {
    exit;
}

$likeColumn = $vote === 'like' ? 'likes' : 'dislikes';
$prevColumn = $prev === 'like' ? 'likes' : ($prev === 'dislike' ? 'dislikes' : null);

if ($prev === $vote) {
    $sql = "
        UPDATE comentarios
        SET $likeColumn = GREATEST($likeColumn - 1, 0)
        WHERE id = :id
    ";
} elseif ($prevColumn) {
    $sql = "
        UPDATE comentarios
        SET $likeColumn = $likeColumn + 1,
            $prevColumn = GREATEST($prevColumn - 1, 0)
        WHERE id = :id
    ";
} else {
    $sql = "
        UPDATE comentarios
        SET $likeColumn = $likeColumn + 1
        WHERE id = :id
    ";
}

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id' => $id
]);

$stmt = $pdo->prepare("
    SELECT likes, dislikes
    FROM comentarios
    WHERE id = :id
");

$stmt->execute([
    ':id' => $id
]);

echo json_encode(
    $stmt->fetch(PDO::FETCH_ASSOC)
);