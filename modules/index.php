<?php
require_once __DIR__ . '/../data/modulos.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AvenTuring — Módulos</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/module.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
</head>
<body>

    <?php include '../components/navbar.php'; ?>

    <!-- Contenedor principal -->
    <div class="module-shell">
        <div class="stats-dashboard">
 
            <div class="stats-col">
                <p class="stats-col-label">🔥 Más visitados</p>
                <div class="stats-col-grid" id="statsPopulares">
                    <p class="catalog-empty">Cargando...</p>
                </div>
            </div>
        
            <div class="stats-col">
                <p class="stats-col-label">⭐ Mejor valorados</p>
                <div class="stats-col-grid" id="statsValorados">
                    <p class="catalog-empty">Cargando...</p>
                </div>
            </div>
        
        </div>

        <!-- Contenido dinámico -->
        <main class="module-main" id="moduleMain">
            <div class="module-loading">Cargando módulo...</div>
        </main>
        <div class="module-recomendados">
            <p class="module-tags-label">👀 También te puede interesar</p>
            <div class="module-tags" id="recomendadosGrid">
                <p class="catalog-empty">Cargando...</p>
            </div>
        </div>
        <!-- Tags de módulos al pie -->
        <div class="module-tags-section">
            <p class="module-tags-label">Explorar módulos</p>
            <div class="module-tags">
                <?php foreach ($modulos as $slug => $data) : ?>
                <button
                    class="module-tag"
                    data-modulo="<?= $slug ?>"
                >
                    <?= $data['icono'] ?> <?= $data['nombre'] ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <?php include '../components/footer.php'; ?>

    <div class="cursor-dot"></div>
    <div id="toastMessage" class="toast-message"></div>

    <!-- Lista de módulos para el JS -->
    <script>
        window.MODULOS = <?= json_encode($modulos) ?>;
        (function(){
            const params = new URLSearchParams(window.location.search);
            const modulo = params.get('modulo');
            if (!modulo) return;

            const fd = new URLSearchParams();
            fd.append('modulo', modulo);
            fetch('../api/modulo-vista.php', { method: 'POST', body: fd });
            window.MODULO_VIEW_COUNTED = modulo;

            const historial = JSON.parse(localStorage.getItem('modulosVisitados') ?? '[]');
            const nuevoHistorial = [modulo, ...historial.filter(s => s !== modulo)].slice(0, 10);
            localStorage.setItem('modulosVisitados', JSON.stringify(nuevoHistorial));
        })();
    </script>

    <script src="../assets/js/animations.js"></script>
    <script src="../assets/js/particles.js"></script>
    <script src="../assets/js/app.js"></script>

</body>
</html>