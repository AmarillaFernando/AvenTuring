<?php

require_once __DIR__ . '/../database/conexion.php';

if (!isset($modulos)) {
    $modulos_data = require __DIR__ . '/../data/modulos.php';
} else {
    $modulos_data = $modulos;
}

$search  = $_GET['search']  ?? '';
$license = $_GET['license'] ?? '';
$modulo  = $_GET['modulo']  ?? '';

$sql = "SELECT s.*, COALESCE(sl.likes_count, 0) AS likes_count
        FROM softwares s
        LEFT JOIN software_likes sl ON sl.software_id = s.id
        WHERE 1";

$params = [];

if ($search != '') {
    $sql .= " AND (nombre LIKE :search OR categoria LIKE :search OR descripcion LIKE :search OR autor LIKE :search)";
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

?>
<section class="catalog" id="catalog">

    <div class="container">

        <div class="section-badge" style="background: var(--color-blue);">
            Catálogo IA
        </div>

        <div class="catalog-top">

            <div>
                <h2 class="section-title">
                    Software de Inteligencia Artificial
                </h2>
                <p class="section-text">
                    Explora herramientas utilizadas en Machine Learning, NLP, automatización y análisis inteligente.
                </p>
            </div>

            <div class="catalog-search">

                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Buscar software..."
                    value="<?= htmlspecialchars($search) ?>"
                >

                <select name="license" class="filter-select">
                    <option value="all">Licencia</option>
                    <option value="Open Source" <?= $license == 'Open Source' ? 'selected' : '' ?>>Open Source</option>
                    <option value="Freemium"    <?= $license == 'Freemium'    ? 'selected' : '' ?>>Freemium</option>
                    <option value="Privativo"   <?= $license == 'Privativo'   ? 'selected' : '' ?>>Privativo</option>
                </select>

                <select name="modulo" class="filter-select filter-select--modulo">
                    <option value="all">Módulo</option>
                    <?php foreach ($modulos_data as $slug => $data) : ?>
                    <option value="<?= $slug ?>" <?= $modulo == $slug ? 'selected' : '' ?>>
                        <?= $data['icono'] ?> <?= $data['nombre'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>

            </div>

        </div>

        <div class="catalog-grid">

            <?php if (empty($softwares)) : ?>
            <p class="catalog-empty" style="grid-column: 1/-1;">
                No se encontraron resultados para los filtros seleccionados.
            </p>
            <?php endif; ?>

            <?php foreach($softwares as $index => $software) : ?>

            <div class="software-card <?= $index >= 6 ? 'software-hidden' : '' ?>">

                <div class="software-header">
                    <div class="software-badge"><?= $software['licencia'] ?></div>
                    <div class="software-year"><?= $software['anio'] ?></div>
                </div>

                <h3><?= $software['nombre'] ?></h3>

                <p class="software-description"><?= $software['descripcion'] ?></p>

                <div class="software-meta">
                    <div class="meta-item">🤖 <?= $software['categoria'] ?></div>
                    <div class="meta-item">👨‍💻 <?= $software['autor'] ?></div>
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

        </div>
        <?php if(count($softwares) > 6): ?>

            <div class="catalog-more">

                <button
                    id="toggleCatalog"
                    class="software-btn"
                >
                    Ver más
                </button>

            </div>

        <?php endif; ?>

    </div>

    <div class="wave-divider">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path
                fill="#7BCC3A"
                d="M0,32L80,42.7C160,53,320,75,480,80C640,85,800,75,960,64C1120,53,1280,43,1360,37.3L1440,32L1440,120L0,120Z">
            </path>
        </svg>
    </div>

</section>