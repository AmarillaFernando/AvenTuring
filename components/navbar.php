<?php
$baseDir = dirname($_SERVER['SCRIPT_NAME']);
if (basename($baseDir) === 'modules') {
    $root = dirname($baseDir);
} else {
    $root = $baseDir;
}
if ($root === '/' || $root === '\\') {
    $root = '';
}
?>
<nav class="navbar">

    <div class="navbar-container">

        <a href="<?= $root ?>/index.php" class="logo">
            Aven<span>Turing</span>
        </a>

        <div class="nav-links">

            <a href="<?= $root ?>/index.php">Inicio</a>
            <a href="<?= $root ?>/#modulos" data-nav="modulos">Módulos</a>
            <a href="<?= $root ?>/#catalog" data-nav="catalog">Catálogo</a>
            <a href="<?= $root ?>/#dashboard" data-nav="dashboard">Dashboard</a>
            <a href="<?= $root ?>/#nlp" data-nav="nlp">NLP Lab</a>
            <a href="<?= $root ?>/#foro" data-nav="foro">Foro</a>

        </div>



        <div class="menu-toggle">
            ☰
        </div>

    </div>

</nav>

<div class="mobile-menu">

    <div class="close-menu">
        ✕
    </div>

    <ul>

        <li><a href="<?= $root ?>/index.php">Inicio</a></li>
        <li><a href="<?= $root ?>/#modulos" data-nav="modulos">Módulos</a></li>
        <li><a href="<?= $root ?>/#catalog" data-nav="catalog">Catálogo</a></li>
        <li><a href="<?= $root ?>/#dashboard" data-nav="dashboard">Dashboard</a></li>
        <li><a href="<?= $root ?>/#nlp" data-nav="nlp">NLP Lab</a></li>
        <li><a href="<?= $root ?>/#foro" data-nav="foro">Foro</a></li>

    </ul>

</div>