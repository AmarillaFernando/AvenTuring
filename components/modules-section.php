<?php
require_once __DIR__ . '/../data/modulos.php';
?>

<section class="modules">

    <div class="container">

        <div class="section-badge" style="background: var(--color-green);">
            Módulos de aprendizaje
        </div>

        <h2 class="section-title">
            Aprende IA de forma visual e interactiva
        </h2>

        <p class="section-text">
            Explora conceptos fundamentales de Inteligencia Artificial mediante ejemplos, software especializado, simulaciones y recursos multimedia.
        </p>

        <div class="modules-grid">

            <a href="modules/index.php?modulo=fundamentos" class="module-card">
                <div class="module-icon">📚</div>
                <h3>Fundamentos IA</h3>
                <p>Sistemas capaces de representar conocimiento y tomar decisiones especializadas.</p>
            </a>

            <a href="modules/index.php?modulo=agentes-inteligentes" class="module-card">
                <div class="module-icon">⚡</div>
                <h3>Agentes Inteligentes</h3>
                <p>Entidades autónomas que perciben su entorno y actúan inteligentemente.</p>
            </a>

            <a href="modules/index.php?modulo=formalizacion" class="module-card">
                <div class="module-icon">🔢</div>
                <h3>Formalización y Abstracción</h3>
                <p>Definición de estados, operadores y espacios de búsqueda en problemas de IA.</p>
            </a>

            <a href="modules/index.php?modulo=busqueda" class="module-card">
                <div class="module-icon">🔍</div>
                <h3>Estrategias de Búsqueda</h3>
                <p>Algoritmos informados y no informados para resolución de problemas.</p>
            </a>

            <a href="modules/index.php?modulo=machine-learning" class="module-card">
                <div class="module-icon">🤖</div>
                <h3>Machine Learning</h3>
                <p>Aprende cómo los sistemas inteligentes identifican patrones y toman decisiones automáticamente.</p>
            </a>

            <a href="modules/index.php?modulo=modelos-aprendizaje" class="module-card">
                <div class="module-icon">📊</div>
                <h3>Modelos de Aprendizaje</h3>
                <p>Clasificación técnica en supervisado, no supervisado, semi-supervisado, activo y reforzado.</p>
            </a>

            <a href="modules/index.php?modulo=aprendizaje-reforzado" class="module-card">
                <div class="module-icon">🎮</div>
                <h3>Aprendizaje Reforzado</h3>
                <p>Algoritmos Q-Learning, SARSA y Procesos de Decisión de Markov.</p>
            </a>

            <a href="modules/index.php?modulo=percepcion-pln" class="module-card">
                <div class="module-icon">💬</div>
                <h3>Percepción y PLN</h3>
                <p>Procesamiento de Lenguaje Natural, reconocimiento de patrones y representación del conocimiento.</p>
            </a>

            <a href="modules/index.php?modulo=sistemas-expertos" class="module-card">
                <div class="module-icon">🧠</div>
                <h3>Sistemas Expertos</h3>
                <p>Base de conocimientos, base de hechos y motor de inferencia.</p>
            </a>

            <a href="modules/index.php?modulo=logica-borrosa" class="module-card">
                <div class="module-icon">🌫️</div>
                <h3>Lógica Borrosa</h3>
                <p>Tratamiento de la incertidumbre mediante grados de pertenencia.</p>
            </a>

            <a href="modules/index.php?modulo=algoritmos-geneticos" class="module-card">
                <div class="module-icon">🧬</div>
                <h3>Algoritmos Genéticos</h3>
                <p>Computación evolutiva basada en selección natural, cruce y mutación.</p>
            </a>

            <a href="modules/index.php?modulo=big-data" class="module-card">
                <div class="module-icon">💾</div>
                <h3>Big Data</h3>
                <p>La pirámide DICS aplicada al procesamiento de datos a gran escala.</p>
            </a>

        </div>

    </div>

</section>

<script>
    window.MODULOS = <?= json_encode($modulos) ?>;
</script>