<?php

require_once __DIR__ . '/../database/conexion.php';

/*
|--------------------------------------------------------------------------
| GUARDAR COMENTARIO
|--------------------------------------------------------------------------
*/

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $modulo = $_POST['modulo'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $comentario = $_POST['comentario'] ?? '';

    if(
        empty($modulo) ||
        empty($usuario) ||
        empty($comentario)
    ){
        exit;
    }

    $sql = "
        INSERT INTO comentarios
        (
            modulo,
            usuario,
            comentario
        )
        VALUES
        (
            :modulo,
            :usuario,
            :comentario
        )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':modulo' => $modulo,
        ':usuario' => $usuario,
        ':comentario' => $comentario
    ]);

    echo 'ok';

    exit;
}

/*
|--------------------------------------------------------------------------
| LISTAR COMENTARIOS
|--------------------------------------------------------------------------
*/

$modulo = $_GET['modulo'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 6; // fetch one extra to detect if there are more comments
$pageSize = 5;
$offset = ($page - 1) * $pageSize;

$stmt = $pdo->prepare("
    SELECT *
    FROM comentarios
    WHERE modulo = :modulo
    ORDER BY fecha DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':modulo', $modulo, PDO::PARAM_STR);
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();

$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($comentarios as $comentario){

    echo '
    <div class="comment-item">

        <strong>'
        .$comentario['usuario'].
        '</strong>

        <p>'
        .$comentario['comentario'].
        '</p>

        <div class="comment-actions">

            <button
                class="comment-like"
                data-id="'.$comentario['id'].'"
            >
                👍 '.$comentario['likes'].'
            </button>

            <button
                class="comment-dislike"
                data-id="'.$comentario['id'].'"
            >
                👎 '.$comentario['dislikes'].'
            </button>

        </div>

    </div>
    ';
}