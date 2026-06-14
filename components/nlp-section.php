<section class="nlp">

    <div class="container">

        <div class="section-badge" style="background: var(--color-violet); color:white;">
            NLP Lab
        </div>

        <h2 class="section-title">
            Búsqueda Inteligente por Lenguaje Natural
        </h2>

        <div class="nlp-box">

            <h3>
                Describe lo que deseas buscar
            </h3>

            <div class="nlp-search">

                <input
                    type="text"
                    id="nlpInput"
                    class="nlp-input"
                    placeholder="Ej: software gratuito para machine learning..."
                    autocomplete="off"
                >

                <button id="nlpVoiceBtn" class="voice-btn" title="Buscar por voz">
                    🎤 Buscar por voz
                </button>

            </div>

            <!-- Estado del micrófono -->
            <div id="nlpVoiceStatus" class="nlp-voice-status" style="display:none;">
                <span class="nlp-listening-dot"></span>
                <span id="nlpVoiceStatusText">Escuchando...</span>
            </div>

            <!-- Resultados -->
            <div id="nlpResults" class="nlp-results" style="display:none;">

                <div id="nlpResultsHeader" class="nlp-results-header"></div>

                <div id="nlpResultsGrid" class="nlp-results-grid"></div>

            </div>

            <!-- Estado vacío / sin resultados -->
            <div id="nlpEmpty" class="nlp-result" style="display:none;">
                <strong>Sin resultados:</strong>
                <p>No se encontraron coincidencias. Intentá con otras palabras.</p>
            </div>

            <!-- Estado inicial (placeholder visible al cargar) -->
            <div id="nlpPlaceholder" class="nlp-result">
                <strong>Resultado inteligente:</strong>
                <p>Escribí o dictá lo que buscás y el sistema encontrará el contenido más relevante.</p>
            </div>

        </div>

    </div>

    <div class="wave-divider">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path
                fill="#FF69C0"
                d="M0,32L80,42.7C160,53,320,75,480,80C640,85,800,75,960,64C1120,53,1280,43,1360,37.3L1440,32L1440,120L0,120Z">
            </path>
        </svg>
    </div>

</section>