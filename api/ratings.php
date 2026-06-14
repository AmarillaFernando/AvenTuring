<?php

require_once __DIR__ . '/../database/conexion.php';

$id = $_POST['id'];

$sql = "
    UPDATE software_likes
    SET likes_count = likes_count + 1
    WHERE software_id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$get = $pdo->prepare("
    SELECT likes_count
    FROM software_likes
    WHERE software_id = :id
");

$get->execute([
    ':id' => $id
]);

$result = $get->fetch(PDO::FETCH_ASSOC);

echo $result['likes_count'];