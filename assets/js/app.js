
/* CURSOR */

const cursor = document.querySelector('.cursor-dot');

if(cursor){

    window.addEventListener('mousemove',(e)=>{

        cursor.style.top = e.clientY + 'px';
        cursor.style.left = e.clientX + 'px';

    });

}
function showToast(message){

    const toast =
        document.getElementById('toastMessage');

    if(!toast){
        return;
    }

    toast.textContent = message;

    toast.classList.add('show');

    setTimeout(() => {

        toast.classList.remove('show');

    },2500);

}

/* COUNTERS */


/* NAVBAR */

const navbar = document.querySelector('.navbar');

window.addEventListener('scroll',()=>{

    if(navbar){

        if(window.scrollY > 50){

            navbar.classList.add('scrolled');

        }else{

            navbar.classList.remove('scrolled');

        }

    }

});

/* MOBILE MENU */

const menuToggle = document.querySelector('.menu-toggle');
const mobileMenu = document.querySelector('.mobile-menu');
const closeMenu = document.querySelector('.close-menu');

if(menuToggle && mobileMenu){

    menuToggle.addEventListener('click',()=>{

        mobileMenu.classList.add('active');

    });

}

if(closeMenu && mobileMenu){

    closeMenu.addEventListener('click',()=>{

        mobileMenu.classList.remove('active');

    });

}
const searchInput = document.querySelector('.search-input');

const catalogGrid = document.querySelector('.catalog-grid');
const apiBase = window.location.pathname.includes('/modules/') ? '../api/' : 'api/';
const COMMENT_PAGE_SIZE = 5;

function getCommentVoteKey(id) {
    return `commentVote:${id}`;
}

function getCommentVote(id) {
    return Boolean(id) ? localStorage.getItem(getCommentVoteKey(id)) : null;
}

function setCommentVote(id, tipo) {
    if (!id) return;
    localStorage.setItem(getCommentVoteKey(id), tipo);
}

function removeCommentVote(id) {
    if (!id) return;
    localStorage.removeItem(getCommentVoteKey(id));
}

function createVoteBurst(btn, tipo) {
    const action = document.createElement('span');
    action.className = 'comment-vote-burst';
    action.textContent = tipo === 'like' ? '👍' : '👎';
    const parent = btn.closest('.comment-actions');
    if (!parent) return;
    parent.appendChild(action);
    setTimeout(() => action.remove(), 600);
}

function applyCommentVoteStates(container) {
    if (!container) return;
    container.querySelectorAll('.comment-item').forEach(item => {
        const likeBtn = item.querySelector('.comment-like');
        const dislikeBtn = item.querySelector('.comment-dislike');
        if (!likeBtn || !dislikeBtn) return;
        const id = likeBtn.dataset.id;
        const vote = getCommentVote(id);
        likeBtn.classList.toggle('active-vote', vote === 'like');
        dislikeBtn.classList.toggle('active-vote', vote === 'dislike');
    });
}

if(searchInput){

    const filterSelect = document.querySelector('.filter-select');

    const doSearch = async () => {
        
        const value = searchInput.value;
        const license = filterSelect ? filterSelect.value : 'all';

        const moduloSelect = document.querySelector('.filter-select--modulo');
        const modulo = moduloSelect ? moduloSelect.value : 'all';
        const url = `api/buscar.php?search=${encodeURIComponent(value)}&license=${encodeURIComponent(license)}&modulo=${encodeURIComponent(modulo)}`;

        try{
            console.log('URL:', url);
            const response = await fetch(url);
            const data = await response.text();
          
            console.log('HTML recibido:', data.length, data.substring(0, 100));
            catalogGrid.innerHTML = data;
            console.log('Grid después:', catalogGrid.innerHTML.length);
            

            catalogGrid.innerHTML = data;

            // Re-animate newly added cards and clear inline styles after animation
            if(window.gsap){
                const newCards = catalogGrid.querySelectorAll('.software-card');
                if(newCards.length){
                    gsap.killTweensOf(newCards);
                    gsap.from(newCards, {
                        y: 40,
                        opacity: 0,
                        stagger: 0.08,
                        duration: 0.8,
                        ease: 'power4.out',
                        clearProps: 'all',
                        onComplete: () => {
                            if(window.ScrollTrigger && ScrollTrigger.refresh) ScrollTrigger.refresh();
                        }
                    });
                } else {
                    if(window.ScrollTrigger && ScrollTrigger.refresh) ScrollTrigger.refresh();
                }
            }

        }catch(err){
            console.error('Search fetch error', err);
        }
    };

    searchInput.addEventListener('keyup', doSearch);

    document.querySelectorAll('.filter-select').forEach(sel => {
        sel.addEventListener('change', doSearch);
    });

}
document.addEventListener('click', async (e) => {

    const area = e.target.closest('.like-area');

    if(!area) return;

    const id = area.dataset.id;

    const formData = new FormData();

    formData.append('id', id);

    const response = await fetch(`${apiBase}ratings.php`, {
        method: 'POST',
        body: formData
    });

    if(!response.ok){
        console.error('Like request failed', response.status, response.statusText);
        return;
    }

    const likes = await response.text();
    const likeCount = area.querySelector('.like-count');

    if(likeCount){
        likeCount.innerHTML = `❤️ ${likes}`;
    } else {
        console.warn('No like-count element found for area', area);
    }

});
/* ===========================
   NLP SEARCH
   =========================== */

(function () {

    const nlpInput      = document.getElementById('nlpInput');
    const voiceBtn      = document.getElementById('nlpVoiceBtn');
    const voiceStatus   = document.getElementById('nlpVoiceStatus');
    const voiceStatusTx = document.getElementById('nlpVoiceStatusText');
    const resultsWrap   = document.getElementById('nlpResults');
    const resultsHeader = document.getElementById('nlpResultsHeader');
    const resultsGrid   = document.getElementById('nlpResultsGrid');
    const emptyState    = document.getElementById('nlpEmpty');
    const placeholder   = document.getElementById('nlpPlaceholder');

    if (!nlpInput) return; // La sección no está en la página

    // ---------- RENDERIZADO ----------

    const tipoLabel = {
        software: '🤖 Software',
        modulo:   '📘 Módulo',
        // Agregá acá nuevos tipos cuando sumes tablas
    };

    function renderResultado(item) {
        return `
            <div class="nlp-card">
                <div class="nlp-card-type">${tipoLabel[item.tipo] ?? item.tipo}</div>
                <h4 class="nlp-card-title">${item.titulo}</h4>
                <p class="nlp-card-desc">${item.descripcion}</p>
                <div class="nlp-card-meta">${item.meta}</div>
                ${item.enlace
                    ? `<a href="${item.enlace}" target="_blank" class="software-btn nlp-card-btn">Explorar</a>`
                    : ''}
            </div>
        `;
    }

    function mostrarResultados(data) {
        placeholder.style.display  = 'none';
        emptyState.style.display   = 'none';

        if (!data.length) {
            resultsWrap.style.display = 'none';
            emptyState.style.display  = 'block';
            return;
        }

        resultsHeader.textContent   = `${data.length} resultado${data.length !== 1 ? 's' : ''} encontrado${data.length !== 1 ? 's' : ''}`;
        resultsGrid.innerHTML       = data.map(renderResultado).join('');
        resultsWrap.style.display   = 'block';
    }

    // ---------- BÚSQUEDA ----------

    let debounceTimer = null;

    async function buscar(query) {
        if (query.trim() === '') {
            resultsWrap.style.display = 'none';
            emptyState.style.display  = 'none';
            placeholder.style.display = 'block';
            return;
        }

        try {
            const res  = await fetch(`api/nlp-buscar.php?q=${encodeURIComponent(query)}`);
            const data = await res.json();
            mostrarResultados(data);
        } catch (err) {
            console.error('NLP search error:', err);
        }
    }

    nlpInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => buscar(nlpInput.value), 350);
    });

    // ---------- VOZ ----------

    const SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        // El navegador no soporta la API (Firefox sin flag, Safari antiguo)
        voiceBtn.title   = 'Tu navegador no soporta búsqueda por voz';
        voiceBtn.style.opacity = '0.4';
        voiceBtn.style.cursor  = 'not-allowed';
        voiceBtn.addEventListener('click', () =>
            showToast('Búsqueda por voz no disponible en este navegador')
        );
    } else {

        const recognition      = new SpeechRecognition();
        recognition.lang       = 'es-AR';
        recognition.continuous = false;
        recognition.interimResults = false;

        let listening = false;

        voiceBtn.addEventListener('click', () => {
            if (listening) {
                recognition.stop();
                return;
            }
            recognition.start();
        });

        recognition.addEventListener('start', () => {
            listening = true;
            voiceBtn.textContent        = '⏹ Detener';
            voiceBtn.classList.add('voice-btn--active');
            voiceStatus.style.display   = 'flex';
            voiceStatusTx.textContent   = 'Escuchando...';
        });

        recognition.addEventListener('result', (e) => {
            const transcript = e.results[0][0].transcript;
            nlpInput.value   = transcript;
            voiceStatusTx.textContent = `Escuché: "${transcript}"`;
            buscar(transcript);
        });

        recognition.addEventListener('end', () => {
            listening = false;
            voiceBtn.textContent = '🎤 Buscar por voz';
            voiceBtn.classList.remove('voice-btn--active');
            setTimeout(() => {
                voiceStatus.style.display = 'none';
            }, 2000);
        });

        recognition.addEventListener('error', (e) => {
            listening = false;
            voiceBtn.textContent = '🎤 Buscar por voz';
            voiceBtn.classList.remove('voice-btn--active');
            voiceStatus.style.display = 'none';

            const mensajes = {
                'not-allowed': 'Permiso de micrófono denegado',
                'no-speech':   'No se detectó voz, intentá de nuevo',
                'network':     'Error de red al procesar la voz',
            };
            showToast(mensajes[e.error] ?? 'Error al usar el micrófono');
        });

    }

})();
/* ===========================
   MÓDULOS — CARGA DINÁMICA
   Pegá este bloque al final de app.js
   reemplaza el bloque anterior de PÁGINAS DE MÓDULO
   =========================== */

(function () {

    const main = document.getElementById('moduleMain');
    if (!main) return; // No es la página de módulos

    let moduloActivo = null;

    const moduleFiles = {
        'fundamentos': 'fundamentos.php',
        'agentes-inteligentes': 'agentes-inteligentes.php',
        'machine-learning': 'machine-learning.php',
        'percepcion-pln': 'nlp.php',
        'redes-neuronales': 'redes-neuronales.php',
        'sistemas-expertos': 'sistemas-expertos.php'
    };

    // ── Cargar un módulo ──────────────────────────────────
    async function cargarModulo(slug) {

        if (slug === moduloActivo) return; // Ya está cargado

        moduloActivo = slug;

        // Marcar tag activo
        document.querySelectorAll('.module-tag').forEach(btn => {
            btn.classList.toggle('module-tag--active', btn.dataset.modulo === slug);
        });

        // Mostrar loading
        main.innerHTML = '<div class="module-loading">Cargando módulo...</div>';
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Fetch del contenido
        const modulePath = moduleFiles[slug];

        if (!modulePath) {
            main.innerHTML = '<div class="module-error">Lo siento, este módulo todavía no está disponible.</div>';
            return;
        }

        const res  = await fetch(modulePath);
        if (!res.ok) {
            main.innerHTML = '<div class="module-error">No se pudo cargar el módulo. Revisa la ruta del archivo.</div>';
            return;
        }

        const html = await res.text();
        main.innerHTML = html;

        // Registrar vista
        const fd = new FormData();
        fd.append('modulo', slug);
        fetch(`${apiBase}modulo-vista.php`, { method: 'POST', body: fd });

        // Cargar catálogo y comentarios en paralelo
        clearCommentPagination();
        await Promise.all([
            cargarCatalogo(slug),
            cargarComentarios(slug),
        ]);

        // Bind del botón de comentario
        bindSendComment(slug);
        if (window.registrarVisitaLocal) window.registrarVisitaLocal(slug);
        if (window.initModuleRating) window.initModuleRating(main, slug);

        if (window.cargarEstadisticas) {
            window.cargarEstadisticas(
                document.getElementById('recomendadosGrid'),'populares',slug);
        }
    }

    // ── Catálogo ─────────────────────────────────────────
    async function cargarCatalogo(slug) {
        const grid = main.querySelector('#moduleCatalogGrid');
        if (!grid) return;
        try {
            const res  = await fetch(`${apiBase}buscar.php?modulo=` + encodeURIComponent(slug));
            const html = await res.text();
            grid.innerHTML = html || '<p class="catalog-empty">No hay software registrado para este módulo.</p>';
        } catch (e) {
            grid.innerHTML = '<p class="catalog-empty">Error al cargar el software.</p>';
        }
    }

    let currentCommentPage = 1;
    let commentsLoadMoreBtn = null;

    function clearCommentPagination() {
        currentCommentPage = 1;
        if (commentsLoadMoreBtn) {
            commentsLoadMoreBtn.remove();
            commentsLoadMoreBtn = null;
        }
    }

    function createCommentsLoadMoreButton(container, slug) {
        if (commentsLoadMoreBtn && commentsLoadMoreBtn.parentNode) return commentsLoadMoreBtn;

        commentsLoadMoreBtn = document.createElement('button');
        commentsLoadMoreBtn.className = 'software-btn load-more-comments';
        commentsLoadMoreBtn.textContent = 'Ver más comentarios';

        commentsLoadMoreBtn.addEventListener('click', async () => {
            currentCommentPage++;
            await cargarComentarios(slug, true);
        });

        container.insertAdjacentElement('afterend', commentsLoadMoreBtn);
        return commentsLoadMoreBtn;
    }

    async function cargarComentarios(slug, append = false) {
        const container = main.querySelector('.comments-list');
        if (!container) return;

        try {
            const res  = await fetch(`${apiBase}comentarios.php?modulo=` + encodeURIComponent(slug) + '&page=' + currentCommentPage);
            const html = await res.text();
            const fragment = document.createElement('div');
            fragment.innerHTML = html;
            const items = Array.from(fragment.children);
            const hasMore = items.length > COMMENT_PAGE_SIZE;

            if (hasMore) {
                items.pop();
            }

            if (!append) {
                container.innerHTML = '';
            }

            if (items.length === 0 && !append) {
                container.innerHTML = '<p class="catalog-empty">No hay comentarios todavía.</p>';
            } else {
                items.forEach(item => container.appendChild(item));
            }

            applyCommentVoteStates(container);
            const loadMoreBtn = createCommentsLoadMoreButton(container, slug);
            loadMoreBtn.style.display = hasMore ? 'inline-block' : 'none';
        } catch (e) {
            container.innerHTML = '<p class="catalog-empty">Error al cargar comentarios.</p>';
        }
    }

    // ── Publicar comentario ───────────────────────────────
    function bindSendComment(slug) {
        const btn = main.querySelector('#sendComment');
        if (!btn) return;

        btn.addEventListener('click', async () => {
            const usuario    = main.querySelector('#commentUser').value;
            const comentario = main.querySelector('#commentText').value;

            if (!usuario.trim() || !comentario.trim()) {
                showToast('Completa todos los campos');
                return;
            }

            const fd = new FormData();
            fd.append('modulo',     slug);
            fd.append('usuario',    usuario);
            fd.append('comentario', comentario);

            const res = await fetch(`${apiBase}comentarios.php`, { method: 'POST', body: fd });

            if (await res.text() === 'ok') {
                main.querySelector('#commentUser').value = '';
                main.querySelector('#commentText').value = '';
                clearCommentPagination();
                cargarComentarios(slug);
                showToast('Comentario publicado');
            }
        });
    }

    // ── Tags de módulos ───────────────────────────────────
    document.querySelectorAll('.module-tag').forEach(btn => {
        btn.addEventListener('click', () => cargarModulo(btn.dataset.modulo));
    });

    // ── Dropdown del navbar ───────────────────────────────
    const navModulos = document.querySelector('a[href="#modulos"], a[data-nav="modulos"]');
    if (navModulos && window.MODULOS) {

        // Crear dropdown
        const dropdown = document.createElement('div');
        dropdown.className = 'nav-dropdown';
        dropdown.innerHTML = Object.entries(window.MODULOS)
            .map(([slug, data]) => `<button class="nav-dropdown-item" data-modulo="${slug}">${data.icono} ${data.nombre}</button>`)
            .join('');

        navModulos.parentElement.style.position = 'relative';
        navModulos.parentElement.appendChild(dropdown);

        navModulos.addEventListener('click', (e) => {
            e.preventDefault();
            dropdown.classList.toggle('nav-dropdown--active');
            navModulos.classList.toggle('nav-dropdown--active');
        });

        dropdown.querySelectorAll('.nav-dropdown-item').forEach(item => {
            item.addEventListener('click', () => {
                dropdown.classList.remove('nav-dropdown--active');
                cargarModulo(item.dataset.modulo);
                window.location.href = 'modules/index.php';
            });
        });

        document.addEventListener('click', (e) => {
            if (!navModulos.parentElement.contains(e.target)) {
                dropdown.classList.remove('nav-dropdown--active');
                navModulos.classList.remove('nav-dropdown--active');
            }
        });
    }

    // ── Cargar módulo desde query string o fundamentos por defecto ────────────────────
    const params = new URLSearchParams(window.location.search);
    const initialModulo = params.get('modulo');
    const moduloSlug = initialModulo && typeof window.MODULOS === 'object' && window.MODULOS[initialModulo]
        ? initialModulo
        : 'fundamentos';

    cargarModulo(moduloSlug);

    window.cargarModuloGlobal = cargarModulo;

    setTimeout(() => {
        if (window.cargarEstadisticas) {
            window.cargarEstadisticas(document.getElementById('statsPopulares'), 'populares');
            window.cargarEstadisticas(document.getElementById('statsValorados'), 'valorados');
        }
    }, 0);

})();
// ===========================
// MÓDULOS — Soporte para páginas estáticas (meta[name="modulo"]) 
// Carga catálogo y comentarios cuando la página ya contiene el HTML del módulo
// ===========================

(function(){

    const grid = document.getElementById('moduleCatalogGrid');
    const container = document.querySelector('.comments-list');
    const meta = document.querySelector('meta[name="modulo"]');
    const modulo = meta ? meta.content : null;

    if(!modulo) return; // No es una página de módulo estática

    async function cargarCatalogoStatic(){
        if(!grid) return;
        try{
            const res = await fetch(`${apiBase}buscar.php?modulo=` + encodeURIComponent(modulo));
            const html = await res.text();
            grid.innerHTML = html || '<p class="catalog-empty">No hay software registrado para este módulo.</p>';
        }catch(e){
            grid.innerHTML = '<p class="catalog-empty">Error al cargar el software.</p>';
        }
    }

    let currentCommentPageStatic = 1;
    let commentsLoadMoreBtnStatic = null;

    function clearCommentPaginationStatic() {
        currentCommentPageStatic = 1;
        if (commentsLoadMoreBtnStatic) {
            commentsLoadMoreBtnStatic.remove();
            commentsLoadMoreBtnStatic = null;
        }
    }

    function createCommentsLoadMoreButtonStatic(container) {
        if (commentsLoadMoreBtnStatic && commentsLoadMoreBtnStatic.parentNode) return commentsLoadMoreBtnStatic;

        commentsLoadMoreBtnStatic = document.createElement('button');
        commentsLoadMoreBtnStatic.className = 'software-btn load-more-comments';
        commentsLoadMoreBtnStatic.textContent = 'Ver más comentarios';

        commentsLoadMoreBtnStatic.addEventListener('click', async () => {
            currentCommentPageStatic++;
            await cargarComentariosStatic(true);
        });

        container.insertAdjacentElement('afterend', commentsLoadMoreBtnStatic);
        return commentsLoadMoreBtnStatic;
    }

    async function cargarComentariosStatic(append = false){
        if(!container) return;
        try{
            const res = await fetch(`${apiBase}comentarios.php?modulo=` + encodeURIComponent(modulo) + '&page=' + currentCommentPageStatic);
            const html = await res.text();
            const fragment = document.createElement('div');
            fragment.innerHTML = html;
            const items = Array.from(fragment.children);
            const hasMore = items.length > COMMENT_PAGE_SIZE;

            if (hasMore) items.pop();

            if (!append) container.innerHTML = '';

            if (items.length === 0 && !append) {
                container.innerHTML = '<p class="catalog-empty">No hay comentarios todavía.</p>';
            } else {
                items.forEach(item => container.appendChild(item));
            }

            applyCommentVoteStates(container);
            const loadMoreBtn = createCommentsLoadMoreButtonStatic(container);
            loadMoreBtn.style.display = hasMore ? 'inline-block' : 'none';
        }catch(e){
            container.innerHTML = '<p class="catalog-empty">Error al cargar comentarios.</p>';
        }
    }

    function bindSendCommentStatic(){
        const btn = document.getElementById('sendComment');
        if(!btn) return;

        btn.addEventListener('click', async () => {
            const usuario = document.getElementById('commentUser').value;
            const comentario = document.getElementById('commentText').value;

            if(!usuario.trim() || !comentario.trim()){
                showToast('Completa todos los campos');
                return;
            }

            const fd = new FormData();
            fd.append('modulo', modulo);
            fd.append('usuario', usuario);
            fd.append('comentario', comentario);

            try{
                const res = await fetch(`${apiBase}comentarios.php`, { method: 'POST', body: fd });
                if(await res.text() === 'ok'){
                    document.getElementById('commentUser').value = '';
                    document.getElementById('commentText').value = '';
                    clearCommentPaginationStatic();
                    cargarComentariosStatic();
                    showToast('Comentario publicado');
                }
            }catch(e){
                console.error('Error publicando comentario', e);
            }
        });
    }

    // Inicializar
    cargarCatalogoStatic();
    clearCommentPaginationStatic();
    cargarComentariosStatic();
    bindSendCommentStatic();

})();

// ── Likes / Dislikes para comentarios ─────────────────────────────────

document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.comment-like, .comment-dislike');
    if (!btn) return;

    const id = btn.dataset.id;
    const tipo = btn.classList.contains('comment-like') ? 'like' : 'dislike';

    if (!id) return;

    const prevVote = getCommentVote(id);
    const isSameVote = prevVote === tipo;
    const fd = new FormData();
    fd.append('id', id);
    fd.append('vote', tipo);
    fd.append('prev', prevVote || '');

    btn.classList.add('comment-button-animate');
    createVoteBurst(btn, tipo);
    setTimeout(() => btn.classList.remove('comment-button-animate'), 300);

    try {
        const res = await fetch(`${apiBase}rating-comentario.php`, { method: 'POST', body: fd });
        if (!res.ok) throw new Error('Error actualizando rating');

        const data = await res.json();
        const commentItem = btn.closest('.comment-item') || btn.closest('.comment-card');
        if (commentItem) {
            const likeBtn = commentItem.querySelector('.comment-like');
            const dislikeBtn = commentItem.querySelector('.comment-dislike');
            if (likeBtn) likeBtn.innerText = `👍 ${data.likes}`;
            if (dislikeBtn) dislikeBtn.innerText = `👎 ${data.dislikes}`;

            if (isSameVote) {
                if (likeBtn) likeBtn.classList.remove('active-vote');
                if (dislikeBtn) dislikeBtn.classList.remove('active-vote');
                removeCommentVote(id);
            } else {
                if (tipo === 'like') {
                    if (likeBtn) likeBtn.classList.add('active-vote');
                    if (dislikeBtn) dislikeBtn.classList.remove('active-vote');
                } else {
                    if (dislikeBtn) dislikeBtn.classList.add('active-vote');
                    if (likeBtn) likeBtn.classList.remove('active-vote');
                }
                setCommentVote(id, tipo);
            }
        }
    } catch (err) {
        console.error('Error actualizando comentario:', err);
    }
});
(function () {

    const MODULOS_DATA = {
        'fundamentos':           { nombre: 'Fundamentos IA',              icono: '📚' },
        'agentes-inteligentes':  { nombre: 'Agentes Inteligentes',        icono: '⚡' },
        'formalizacion':         { nombre: 'Formalización y Abstracción', icono: '🔢' },
        'busqueda':              { nombre: 'Estrategias de Búsqueda',     icono: '🔍' },
        'machine-learning':      { nombre: 'Machine Learning',            icono: '🤖' },
        'modelos-aprendizaje':   { nombre: 'Modelos de Aprendizaje',      icono: '📊' },
        'aprendizaje-reforzado': { nombre: 'Aprendizaje Reforzado',       icono: '🎮' },
        'percepcion-pln':        { nombre: 'Percepción y PLN',            icono: '💬' },
        'sistemas-expertos':     { nombre: 'Sistemas Expertos',           icono: '🧠' },
        'logica-borrosa':        { nombre: 'Lógica Borrosa',              icono: '🌫️' },
        'algoritmos-geneticos':  { nombre: 'Algoritmos Genéticos',        icono: '🧬' },
        'big-data':              { nombre: 'Big Data',                    icono: '💾' },
    };

    const modulesData = (typeof window.MODULOS === 'object' && window.MODULOS !== null)
        ? window.MODULOS
        : MODULOS_DATA;

    const isModulesPage = !!document.getElementById('moduleMain');
    const base = isModulesPage ? 'index.php' : 'modules/index.php';

    const navModulos = document.querySelector('a[data-nav="modulos"]');
    if (!navModulos) return;

    const dropdown = document.createElement('div');
    dropdown.className = 'nav-dropdown';
    dropdown.innerHTML = Object.entries(modulesData)
        .map(([slug, data]) =>
            `<a href="${base}?modulo=${slug}" class="nav-dropdown-item">
                ${data.icono} ${data.nombre}
            </a>`
        ).join('');

    navModulos.parentElement.style.position = 'relative';
    navModulos.parentElement.appendChild(dropdown);

    navModulos.addEventListener('click', (e) => {
        e.preventDefault();
        dropdown.classList.toggle('nav-dropdown--active');
        navModulos.classList.toggle('nav-dropdown--active');
    });

    document.addEventListener('click', (e) => {
        if (!navModulos.parentElement.contains(e.target)) {
            dropdown.classList.remove('nav-dropdown--active');
            navModulos.classList.remove('nav-dropdown--active');
        }
    });

})();
/* ===========================
   RATING DE MÓDULOS — ESTRELLAS CON MEDIA
   Pegá este bloque al final de app.js
   =========================== */

(function () {

    const LABELS = ['Muy malo', 'Malo', 'Regular', 'Bueno', 'Excelente'];

    function initRating(container, slug) {

        const starsContainer = container.querySelector('#starsContainer');
        const feedback       = container.querySelector('#ratingFeedback');
        const averageEl      = container.querySelector('#ratingAverage');

        if (!starsContainer) return;

        // ── Construir 5 estrellas SVG ─────────────────────
        starsContainer.innerHTML = '';

        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('span');
            star.className   = 'rating-star';
            star.dataset.pos = i;
            star.innerHTML   = `
                <svg viewBox="0 0 24 24" class="star-svg">
                    <defs>
                        <linearGradient id="half-${i}" x1="0" x2="1" y1="0" y2="0">
                            <stop offset="50%" stop-color="var(--star-fill, #ccc)"/>
                            <stop offset="50%" stop-color="#ccc"/>
                        </linearGradient>
                    </defs>
                    <polygon
                        class="star-poly"
                        points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"
                        fill="#ccc"
                        stroke="#ccc"
                        stroke-width="1"
                    />
                </svg>`;
            starsContainer.appendChild(star);
        }

        const stars = starsContainer.querySelectorAll('.rating-star');
        let votado  = false;
        let votoActual = 0;

        // ── Cargar promedio actual ────────────────────────
        async function cargarPromedio() {
            try {
                const res  = await fetch(`${apiBase}modulo-rating-get.php?modulo=${encodeURIComponent(slug)}`);
                const data = await res.json();
                if (data.total > 0) {
                    averageEl.textContent = `Promedio: ${data.promedio} ⭐ (${data.total} votos)`;
                    pintarEstrellas(data.promedio, stars);
                    votoActual = data.promedio;
                }
            } catch (e) { /* silencioso */ }
        }

        // ── Pintar estrellas con soporte de media ─────────
        function pintarEstrellas(valor, starEls) {
            starEls.forEach((star, idx) => {
                const poly = star.querySelector('.star-poly');
                const grad = star.querySelector('linearGradient');
                const pos  = idx + 1;

                if (valor >= pos) {
                    // Estrella completa
                    poly.setAttribute('fill', '#f5a623');
                    poly.setAttribute('stroke', '#f5a623');
                    if (grad) grad.querySelector('stop:first-child').setAttribute('stop-color', '#f5a623');
                } else if (valor >= pos - 0.5) {
                    // Media estrella
                    poly.setAttribute('fill', `url(#half-${pos})`);
                    poly.setAttribute('stroke', '#f5a623');
                    if (grad) {
                        grad.querySelectorAll('stop')[0].setAttribute('stop-color', '#f5a623');
                        grad.querySelectorAll('stop')[1].setAttribute('stop-color', '#ccc');
                    }
                } else {
                    // Vacía
                    poly.setAttribute('fill', '#ccc');
                    poly.setAttribute('stroke', '#ccc');
                }
            });
        }

        // ── Hover con detección de mitad ──────────────────
        starsContainer.addEventListener('mousemove', (e) => {
            if (votado) return;
            const star = e.target.closest('.rating-star');
            if (!star) return;

            const rect  = star.getBoundingClientRect();
            const half  = e.clientX < rect.left + rect.width / 2;
            const pos   = parseInt(star.dataset.pos);
            const valor = half ? pos - 0.5 : pos;

            pintarEstrellas(valor, stars);
            feedback.textContent = half
                ? `${valor} — ${LABELS[pos - 1]}`
                : `${valor} — ${LABELS[pos - 1]}`;
        });

        starsContainer.addEventListener('mouseleave', () => {
            if (votado) return;
            pintarEstrellas(votoActual, stars);
            feedback.textContent = 'Pasá el cursor para valorar';
        });

        // ── Click para votar ──────────────────────────────
        starsContainer.addEventListener('click', async (e) => {
            if (votado) {
                showToast('Ya valoraste este módulo');
                return;
            }

            const star = e.target.closest('.rating-star');
            if (!star) return;

            const rect  = star.getBoundingClientRect();
            const half  = e.clientX < rect.left + star.getBoundingClientRect().width / 2;
            const pos   = parseInt(star.dataset.pos);
            const valor = half ? pos - 0.5 : pos;

            const fd = new FormData();
            fd.append('modulo',    slug);
            fd.append('estrellas', valor);

            try {
                const res  = await fetch(`${apiBase}modulo-rating.php`, { method: 'POST', body: fd });
                const data = await res.json();

                if (data.ok) {
                    votado     = true;
                    votoActual = valor;
                    pintarEstrellas(valor, stars);
                    feedback.textContent    = `¡Gracias por tu voto! (${valor} ⭐)`;
                    averageEl.textContent   = `Promedio: ${data.promedio} ⭐ (${data.total} votos)`;
                    starsContainer.style.cursor = 'default';
                    showToast('Voto registrado');
                }
            } catch (e) {
                showToast('Error al registrar el voto');
            }
        });

        cargarPromedio();
    }

    // ── Exportar para que el loader de módulos lo llame ──
    window.initModuleRating = initRating;

})();
/* ===========================
   ESTADÍSTICAS DE MÓDULOS
   Pegá este bloque al final de app.js
   =========================== */

(function () {

    const ICONOS = {
        'fundamentos':           '📚',
        'agentes-inteligentes':  '⚡',
        'formalizacion':         '🔢',
        'busqueda':              '🔍',
        'machine-learning':      '🤖',
        'modelos-aprendizaje':   '📊',
        'aprendizaje-reforzado': '🎮',
        'percepcion-pln':        '💬',
        'sistemas-expertos':     '🧠',
        'logica-borrosa':        '🌫️',
        'algoritmos-geneticos':  '🧬',
        'big-data':              '💾',
    };

    function renderStatCard(mod, tipo) {
        const icono = ICONOS[mod.id] ?? '📘';
        const meta  = tipo === 'populares'
            ? `👀 ${mod.vistas} vista${mod.vistas !== 1 ? 's' : ''}`
            : `⭐ ${mod.promedio} (${mod.votos} voto${mod.votos !== 1 ? 's' : ''})`;

        return `
            <button class="stat-card module-tag" data-modulo="${mod.id}">
                <span class="stat-card-icon">${icono}</span>
                <span class="stat-card-name">${mod.nombre}</span>
                <span class="stat-card-meta">${meta}</span>
            </button>
        `;
    }

    async function cargarEstadisticas(contenedor, tipo, excluir = '') {
        if (!contenedor) return;

        try {
            const base = window.location.pathname.includes('/modules/') ? '../api/' : 'api/';
            const url = `${base}estadisticas.php?tipo=${tipo}&excluir=${encodeURIComponent(excluir)}`;            const res  = await fetch(url);
            const data = await res.json();

            if (!data.length) {
                contenedor.innerHTML = '<p class="catalog-empty">Sin datos todavía.</p>';
                return;
            }

            contenedor.innerHTML = data.map(m => renderStatCard(m, tipo)).join('');

            // Bindear clicks a los botones generados
            contenedor.querySelectorAll('.module-tag').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (window.cargarModuloGlobal) {
                        window.cargarModuloGlobal(btn.dataset.modulo);
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                });
            });

        } catch (e) {
            contenedor.innerHTML = '<p class="catalog-empty">Error al cargar estadísticas.</p>';
        }
    }

    // Exportar para uso externo
    window.cargarEstadisticas = cargarEstadisticas;

})();
/* ===========================
   FORO — PAGINACIÓN
   Pegá este bloque al final de app.js
   =========================== */

(function () {

    const forumGrid = document.getElementById('forumGrid');
    if (!forumGrid) return;

    document.addEventListener('click', async (e) => {

        const btn = e.target.closest('#forumLoadMore');
        if (!btn) return;

        const page = parseInt(btn.dataset.page ?? 2);
        btn.textContent = 'Cargando...';
        btn.disabled = true;

        try {
            const res  = await fetch(`components/forum.php?page=${page}`);
            const html = await res.text();

            // Parsear la respuesta y extraer solo las cards y el nuevo botón
            const tmp = document.createElement('div');
            tmp.innerHTML = html;

            const newCards = tmp.querySelectorAll('.comment-card');
            newCards.forEach(card => forumGrid.appendChild(card));

            // Actualizar o eliminar el botón
            const newBtn = tmp.querySelector('#forumLoadMore');
            if (newBtn) {
                btn.dataset.page = newBtn.dataset.page;
                btn.textContent  = 'Ver más comentarios';
                btn.disabled     = false;
            } else {
                btn.closest('.forum-load-more').remove();
            }

            // Aplicar estados de voto a los nuevos comentarios
            applyCommentVoteStates(forumGrid);

        } catch (e) {
            btn.textContent = 'Error al cargar';
            btn.disabled = false;
        }

    });

})();
/* ===========================
   DASHBOARD
   Pegá este bloque al final de app.js
   =========================== */

(function () {

    const activityList     = document.getElementById('dashActivityList');
    const recommendationTx = document.getElementById('dashRecommendationText');
    const dashChart        = document.getElementById('dashChart');

    if (!activityList) return; // No está en la página

    const MODULOS_NOMBRES = {
        'fundamentos':           { nombre: 'Fundamentos IA',              icono: '📚' },
        'agentes-inteligentes':  { nombre: 'Agentes Inteligentes',        icono: '⚡' },
        'formalizacion':         { nombre: 'Formalización y Abstracción', icono: '🔢' },
        'busqueda':              { nombre: 'Estrategias de Búsqueda',     icono: '🔍' },
        'machine-learning':      { nombre: 'Machine Learning',            icono: '🤖' },
        'modelos-aprendizaje':   { nombre: 'Modelos de Aprendizaje',      icono: '📊' },
        'aprendizaje-reforzado': { nombre: 'Aprendizaje Reforzado',       icono: '🎮' },
        'percepcion-pln':        { nombre: 'Percepción y PLN',            icono: '💬' },
        'sistemas-expertos':     { nombre: 'Sistemas Expertos',           icono: '🧠' },
        'logica-borrosa':        { nombre: 'Lógica Borrosa',              icono: '🌫️' },
        'algoritmos-geneticos':  { nombre: 'Algoritmos Genéticos',        icono: '🧬' },
        'big-data':              { nombre: 'Big Data',                    icono: '💾' },
    };

    // ── Actividad reciente desde localStorage ────────────
    async function cargarActividad() {
        try {
            const res  = await fetch('api/estadisticas.php?tipo=populares');
            const data = await res.json();

            if (!data.length) {
                activityList.innerHTML = '<div class="activity-item activity-empty">Sin actividad todavía.</div>';
                return;
            }

            activityList.innerHTML = data.map(m => {
                const info = MODULOS_NOMBRES[m.id];
                if (!info) return '';
                return `
                    <a href="modules/index.php?modulo=${m.id}" class="activity-item activity-link">
                        ${info.icono} <strong>${info.nombre}</strong>
                        <span class="activity-vistas">👀 ${m.vistas} vista${m.vistas !== 1 ? 's' : ''}</span>
                    </a>`;
            }).join('');

        } catch (e) {
            activityList.innerHTML = '<div class="activity-item activity-empty">Error al cargar actividad.</div>';
        }
    }

    // ── Recomendación: mejor valorado no visitado ─────────
    async function cargarRecomendacion() {
        try {
            const res  = await fetch('api/estadisticas.php?tipo=valorados');
            const data = await res.json();

            const historial = JSON.parse(localStorage.getItem('modulosVisitados') ?? '[]');

            // Primer módulo bien valorado que no hayas visitado
            const recomendado = data.find(m => !historial.includes(m.id));

            if (recomendado) {
                const info = MODULOS_NOMBRES[recomendado.id];
                recommendationTx.innerHTML = `
                    Según las valoraciones de la comunidad, te recomendamos explorar
                    <a href="modules/index.php?modulo=${recomendado.id}" class="dash-rec-link">
                        ${info?.icono ?? '📘'} ${recomendado.nombre}
                    </a>
                    — promedio de ${recomendado.promedio} ⭐
                `;
            } else {
                recommendationTx.textContent = '¡Ya exploraste los módulos mejor valorados!';
            }
        } catch (e) {
            recommendationTx.textContent = 'No se pudo cargar la recomendación.';
        }
    }

    // ── Gráfico de barras con datos reales ───────────────
    async function cargarGrafico() {
        try {
            const res  = await fetch('api/estadisticas.php?tipo=populares');
            const data = await res.json();

            // Traer todos los módulos para el gráfico completo
            const resAll = await fetch('api/estadisticas.php?tipo=populares&limit=12');
            const todos  = await resAll.json();

            // Usar data (top 3 con vistas) + completar con los demás en 0
            const slugsTodos = Object.keys(MODULOS_NOMBRES);
            const vistasMap  = {};
            todos.forEach(m => vistasMap[m.id] = parseInt(m.vistas));

            const maxVistas = Math.max(1, ...Object.values(vistasMap));

            dashChart.innerHTML = `
                <div class="dash-bars">
                    ${slugsTodos.map(slug => {
                        const info   = MODULOS_NOMBRES[slug];
                        const vistas = vistasMap[slug] ?? 0;
                        const pct    = Math.round((vistas / maxVistas) * 100);
                        return `
                            <div class="dash-bar-row">
                                <span class="dash-bar-label" title="${info.nombre}">
                                    ${info.icono}
                                </span>
                                <div class="dash-bar-track">
                                    <div
                                        class="dash-bar-fill"
                                        style="width: ${pct}%"
                                        title="${info.nombre}: ${vistas} vista${vistas !== 1 ? 's' : ''}"
                                    ></div>
                                </div>
                                <span class="dash-bar-value">${vistas}</span>
                            </div>
                        `;
                    }).join('')}
                </div>
            `;
        } catch (e) {
            dashChart.innerHTML = '<p class="catalog-empty">Error al cargar el gráfico.</p>';
        }
    }

    // ── Registrar visita en localStorage ─────────────────
    // Se llama desde el IIFE de módulos al cargar cada uno
    window.registrarVisitaLocal = function (slug) {
        let historial = JSON.parse(localStorage.getItem('modulosVisitados') ?? '[]');
        historial = [slug, ...historial.filter(s => s !== slug)].slice(0, 10);
        localStorage.setItem('modulosVisitados', JSON.stringify(historial));
    };

    // ── Inicializar ───────────────────────────────────────
    cargarActividad();
    cargarRecomendacion();
    cargarGrafico();

})();
/* ===========================
   STATS DINÁMICAS
   Pegá este bloque al final de app.js
   =========================== */

(function () {

    const elSoftware    = document.getElementById('statSoftware');
    const elModulos     = document.getElementById('statModulos');
    const elComentarios = document.getElementById('statComentarios');

    if (!elSoftware) return;

    async function cargarStats() {
        try {
            const res  = await fetch('api/stats.php');
            const data = await res.json();

            animarContador(elSoftware,    data.software);
            animarContador(elModulos,     data.modulos);
            animarContador(elComentarios, data.comentarios);

        } catch (e) {
            console.error('Stats error:', e);
        }
    }

    function animarContador(el, target) {
        el.dataset.target = target;
        let current = 0;
        const increment = Math.ceil(target / 60);

        const tick = () => {
            current = Math.min(current + increment, target);
            el.textContent = current;
            if (current < target) setTimeout(tick, 30);
        };

        tick();
    }

    cargarStats();

})();