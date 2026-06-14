<?php
require_once __DIR__ . '/../database/conexion.php';

$modulos = require __DIR__ . '/../data/modulos.php';

// Top 2 comentarios por módulo ordenados por likes
$stmt = $pdo->query("
    SELECT c.*
    FROM comentarios c
    INNER JOIN (
        SELECT modulo, id
        FROM (
            SELECT modulo, id,
                   ROW_NUMBER() OVER (PARTITION BY modulo ORDER BY likes DESC) AS rn
            FROM comentarios
        ) ranked
        WHERE rn <= 2
    ) top ON top.id = c.id
    ORDER BY c.modulo, c.likes DESC
");

$comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
$hayMas      = false;
?>
<section class="forum">

    <div class="container">

        <div class="section-badge" style="background: var(--color-yellow);">
            Foro IA
        </div>

        <h2 class="section-title">
            Debates y opiniones
        </h2>

        <p class="section-text">
            Explorá lo que la comunidad opina sobre cada módulo. Para participar, ingresá al módulo que te interese.
        </p>

        <div class="forum-grid" id="forumGrid">

            <?php foreach($comentarios as $c) :
                $moduloSlug   = $c['modulo'] ?? '';
                $moduloNombre = $modulos[$moduloSlug]['nombre'] ?? $moduloSlug;
                $moduloIcono  = $modulos[$moduloSlug]['icono']  ?? '📘';
            ?>

            <div class="comment-card">

                <div class="comment-card-header">

                    <a
                        href="modules/index.php?modulo=<?= htmlspecialchars($moduloSlug) ?>"
                        class="comment-module-badge"
                    >
                        <?= $moduloIcono ?> <?= htmlspecialchars($moduloNombre) ?>
                    </a>

                    <span class="comment-card-date">
                        <?= date('d/m/Y', strtotime($c['fecha'])) ?>
                    </span>

                </div>

                <div class="comment-card-user">
                    <?= htmlspecialchars($c['usuario']) ?>
                </div>

                <div class="comment-card-text">
                    <?= htmlspecialchars($c['comentario']) ?>
                </div>

                <div class="comment-card-footer">

                    <div class="comment-actions">

                        <button
                            class="comment-like"
                            data-id="<?= $c['id'] ?>"
                        >
                            👍 <?= $c['likes'] ?>
                        </button>

                        <button
                            class="comment-dislike"
                            data-id="<?= $c['id'] ?>"
                        >
                            👎 <?= $c['dislikes'] ?>
                        </button>

                    </div>

                    <a
                        href="modules/index.php?modulo=<?= htmlspecialchars($moduloSlug) ?>"
                        class="forum-module-link"
                    >
                        Ir al módulo →
                    </a>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

    <div class="wave-divider">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path
                fill="#FFFFFF"
                d="M0,32L80,42.7C160,53,320,75,480,80C640,85,800,75,960,64C1120,53,1280,43,1360,37.3L1440,32L1440,120L0,120Z">
            </path>
        </svg>
    </div>

</section>