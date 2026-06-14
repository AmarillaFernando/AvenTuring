<?php

require_once __DIR__ . '/../database/conexion.php';

$search  = $_GET['search']  ?? '';
$license = $_GET['license'] ?? '';
$modulo  = $_GET['modulo']  ?? '';

$sql = "SELECT s.*, COALESCE(sl.likes_count, 0) AS likes_count
        FROM softwares s
        LEFT JOIN software_likes sl ON sl.software_id = s.id
        WHERE 1";

$params = [];

if ($search != '') {
    $sql .= " AND (nombre LIKE :search OR categoria LIKE :search OR licencia LIKE :search OR descripcion LIKE :search OR autor LIKE :search)";
    $params[':search'] = "%$search%";
}

if ($license != '' && $license != 'all') {
    $sql .= " AND licencia = :license";
    $params[':license'] = $license;
}

if ($modulo != '' && $modulo != 'all') {
    $sql .= " AND modulo = :modulo";
    $params[':modulo'] = $modulo;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$softwares = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($softwares as $software) : ?>

<div class="software-card">

    <div class="software-header">

        <div class="software-badge">
            <?= $software['licencia'] ?>
        </div>

        <div class="software-year">
            <?= $software['anio'] ?>
        </div>

    </div>

    <h3>
        <?= $software['nombre'] ?>
    </h3>

    <p class="software-description">
        <?= $software['descripcion'] ?>
    </p>

    <div class="software-meta">

        <div class="meta-item">
            🤖 <?= $software['categoria'] ?>
        </div>

        <div class="meta-item">
            👨‍💻 <?= $software['autor'] ?>
        </div>

    </div>

    <div class="software-footer">

        <div class="rating like-area" data-id="<?= $software['id'] ?>">

            <?php for ($i = 0; $i < $software['rating']; $i++) : ?>
                <span class="star">⭐</span>
            <?php endfor; ?>

            <span class="like-count">❤️ <?= $software['likes_count'] ?? 0 ?></span>

        </div>

        <a href="<?= $software['enlace'] ?>" target="_blank" class="software-btn">
            Explorar
        </a>

    </div>

</div>

<?php endforeach; ?>