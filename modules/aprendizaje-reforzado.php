<div class="module-page">

    <div class="module-banner">
        🎮 Aprendizaje reforzado
    </div>

    <h2>Aprendizaje por Ensayo y Error</h2>

    <p>
        El aprendizaje por refuerzo busca que un agente aprenda a mapear situaciones y acciones para maximizar una recompensa acumulada a largo plazo. Es la forma más pura de aprender mediante el ensayo y error.
    </p>

    <h3>Conceptos Principales</h3>

    <div class="concept-grid">

        <div class="concept-card">
            <h4>🕹️ Q-Learning</h4>
            <p>Un algoritmo "libre de modelo" que aprende una función de acción-valor Q(s,a). Esta función le dice al agente qué beneficio obtendrá si ejecuta una acción en un estado determinado.</p>
        </div>

        <div class="concept-card">
            <h4>🔄 SARSA</h4>
            <p>A diferencia de Q-Learning, este algoritmo actualiza su conocimiento basándose en la acción que el agente realmente elige realizar en el siguiente estado.</p>
        </div>

        <div class="concept-card">
            <h4>📊 MDP (Procesos de Decisión de Markov)</h4>
            <p>Es el marco formal del refuerzo; se basa en la propiedad de que el futuro depende solo del estado actual y no de cómo se llegó a él.</p>
        </div>

        <div class="concept-card">
            <h4>🧠 CBR (Razonamiento Basado en Casos)</h4>
            <p>Permite a los bots recordar situaciones pasadas exitosas y adaptar esas soluciones a problemas nuevos, evitando que las tablas de decisión crezcan infinitamente.</p>
        </div>

    </div>

    <div class="examples-box">
        <h3>📚 Ejemplos</h3>
        <ul class="module-list">
            <li><strong>AlphaGo Zero:</strong> Aprendió a jugar al Go sola, jugando millones de partidas contra sí misma hasta ser imbatible.</li>
            <li><strong>Bot de Pac-Man:</strong> Utiliza una "memoria de estados" para registrar situaciones y aprender qué dirección lo aleja de los fantasmas.</li>
        </ul>
    </div>

    <div class="applications-box">
        <h3>🚀 Aplicaciones Actuales</h3>
        <ul class="module-list">
            <li><strong>Navegación de Robots:</strong> Permite que robots físicos o autos autónomos aprendan a circular evitando colisiones.</li>
            <li><strong>Videojuegos:</strong> Entrenamiento de NPCs (personajes no jugables) que se adaptan a la estrategia del jugador humano.</li>
        </ul>
    </div>

    <div class="didyouknow-box">
        <h3>💡 ¿Sabías que?</h3>
        <p>El <strong>MAME Toolkit</strong> es una biblioteca de Python diseñada específicamente para entrenar IAs en juegos clásicos de arcade usando estos mismos algoritmos de refuerzo.</p>
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