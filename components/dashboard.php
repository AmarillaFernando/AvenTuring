<section class="dashboard">

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