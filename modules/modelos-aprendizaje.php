<div class="module-page">

    <div class="module-banner">
        🏷️ Modelos de Aprendizaje
    </div>

    <h2>¿Cómo aprenden los sistemas?</h2>

    <p>
        No todos los sistemas aprenden de la misma manera. La Inteligencia Artificial se clasifica según la "señal de entrenamiento" o el tipo de realimentación que recibe durante su proceso de instrucción.
    </p>

    <h3>Conceptos Principales</h3>

    <div class="concept-grid">

        <div class="concept-card">
            <h4>🟢 Supervisado</h4>
            <p>El sistema aprende mediante datos etiquetados proporcionados por un "maestro". Es ideal para clasificación (spam/no spam) y regresión (predecir precios).</p>
        </div>

        <div class="concept-card">
            <h4>🔵 No Supervisado</h4>
            <p>No hay etiquetas; el algoritmo debe encontrar por sí solo estructuras o patrones ocultos en los datos, como agrupar clientes por comportamiento similar.</p>
        </div>

        <div class="concept-card">
            <h4>🟡 Semi-supervisado</h4>
            <p>Una técnica híbrida donde la computadora recibe una señal incompleta, usando pocos datos etiquetados para dar sentido a una gran masa de datos sin etiquetar.</p>
        </div>

        <div class="concept-card">
            <h4>🟠 Activo</h4>
            <p>El modelo optimiza su aprendizaje eligiendo qué objetos específicos necesita que un experto humano etiquete, ahorrando tiempo y presupuesto.</p>
        </div>

        <div class="concept-card">
            <h4>🔴 Reforzado (RL)</h4>
            <p>El agente aprende mediante un sistema de premios y castigos al interactuar con un entorno dinámico, mejorando sus decisiones de forma iterativa.</p>
        </div>

    </div>

    <div class="examples-box">
        <h3>📚 Ejemplos</h3>
        <ul class="module-list">
            <li><strong>Filtros de Spam:</strong> Un ejemplo clásico de aprendizaje supervisado.</li>
            <li><strong>Clustering de Datos:</strong> Agrupamiento de perfiles de usuario sin categorías previas (No supervisado).</li>
        </ul>
    </div>

    <div class="applications-box">
        <h3>🚀 Aplicaciones Actuales</h3>
        <ul class="module-list">
            <li><strong>Diagnóstico Médico:</strong> Sistemas entrenados con imágenes etiquetadas para detectar enfermedades.</li>
            <li><strong>Marketing Inteligente:</strong> Segmentación automática de mercados basada en similitudes detectadas por el algoritmo.</li>
        </ul>
    </div>

    <div class="didyouknow-box">
        <h3>💡 ¿Sabías que?</h3>
        <p>El <strong>aprendizaje activo</strong> es fundamental cuando el costo de etiquetar datos es muy alto, haciendo que la máquina "pregunte" solo lo que realmente le genera dudas.</p>
    </div>

    <div class="module-catalog">
        <h3>🖥️ Software relacionado</h3>
        <div class="module-catalog-grid" id="moduleCatalogGrid">
            <p class="catalog-loading">Cargando software...</p>
        </div>
    </div>

    <div class="module-videos">
        <h3>🎬 Material multimedia</h3>
        <div class="module-videos-grid">
            <p class="catalog-loading">Próximamente...</p>
        </div>
    </div>

    <div class="module-rating">
        <h3>⭐ Valora este tema</h3>
        <div class="rating-widget">
            <div class="stars-container" id="starsContainer">
                </div>
            <p class="rating-feedback" id="ratingFeedback">Pasá el cursor para valorar</p>
            <p class="rating-average" id="ratingAverage"></p>
        </div>
    </div>

    <div class="module-comments">
        <h3>💬 Comentarios</h3>
        <p>Comparte tu opinión sobre este tema y participa en el debate.</p>
        <input type="text" class="comment-input" id="commentUser" placeholder="Tu nombre">
        <textarea class="comment-textarea" id="commentText" placeholder="Escribe tu comentario..."></textarea>
        <button class="software-btn" id="sendComment">Publicar comentario</button>
        <div class="comments-list"></div>
    </div>

</div>