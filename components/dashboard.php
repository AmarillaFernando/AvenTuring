<section class="dashboard" id="dashboard">

     <div class="wave-divider flip">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path
                fill="#7BCC3A"
                d="M0,32L80,42.7C160,53,320,75,480,80C640,85,800,75,960,64C1120,53,1280,43,1360,37.3L1440,32L1440,120L0,120Z">
            </path>
        </svg>
    </div>

    <div class="container">

        <div class="section-badge" style="background: var(--color-blue);">
            Dashboard Inteligente
        </div>

        <h2 class="section-title">
            Analiza tu experiencia de aprendizaje
        </h2>

        <div class="dashboard-grid">

            <!-- Card izquierda: actividad + recomendación -->
            <div class="dashboard-card">

                <h3>Actividad reciente</h3>

                <div class="activity-list" id="dashActivityList">
                    <div class="activity-item activity-empty">
                        Todavía no visitaste ningún módulo.
                    </div>
                </div>

                <div class="recommendation-box" id="dashRecommendation">
                    <strong>Recomendación IA:</strong>
                    <p id="dashRecommendationText">Cargando recomendación...</p>
                </div>

            </div>

            <!-- Card derecha: gráfico de vistas -->
            <div class="dashboard-card">

                <h3>Módulos más visitados</h3>

                <div class="dash-chart" id="dashChart">
                    <p class="catalog-empty">Cargando estadísticas...</p>
                </div>

            </div>

        </div>

    </div>

</section>