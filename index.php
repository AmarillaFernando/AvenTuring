<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AvenTuring</title>

    <!-- GOOGLE FONTS -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- CSS -->

    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/module.css">
    <!-- GSAP -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>


</head>

<body>

    <?php include 'components/navbar.php'; ?>
    <?php include 'components/hero.php'; ?>
    <?php include 'components/stats.php'; ?>
    <?php include 'components/modules-section.php'; ?>
    <?php include 'components/catalog.php'; ?>
    <?php include 'components/dashboard.php'; ?>
    <?php include 'components/nlp-section.php'; ?>
    <?php include 'components/forum.php'; ?>
    <?php include 'components/ai-explained.php'; ?>
    
    <div class="cursor-dot"></div>
    <script src="assets/js/animations.js"></script>
    <script src="assets/js/particles.js"></script>
    <script src="assets/js/app.js"></script>
    <div id="toastMessage" class="toast-message"></div>
</body>

</html>