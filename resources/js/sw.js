/**
 * MiFire CMS - Service Worker
 * Estratégia: Network-first para páginas, Cache-first para assets estáticos
 */

const CACHE_VERSION = 'mifire-v1.0.0';
const STATIC_CACHE = `${CACHE_VERSION}-static`;
const PAGES_CACHE = `${CACHE_VERSION}-pages`;
const IMAGES_CACHE = `${CACHE_VERSION}-images`;

// Assets para pré-cache (instalação)
const PRE_CACHE_ASSETS = [
    '/',
    '/offline',
    '/build/assets/app.css',
    '/build/assets/app.js',
];

// Padrões de URL para cache de assets estáticos
const STATIC_EXTENSIONS = /\.(css|js|woff|woff2|ttf|eot|otf)(\?.*)?$/i;
const IMAGE_EXTENSIONS = /\.(png|jpg|jpeg|gif|svg|webp|ico|avif)(\?.*)?$/i;

/**
 * INSTALL - Pré-cacheia assets essenciais
 */
self.addEventListener('install', (event) => {
    console.log('[SW] Instalando Service Worker...');

    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => {
                console.log('[SW] Pré-cacheando assets essenciais');
                return cache.addAll(PRE_CACHE_ASSETS);
            })
            .then(() => {
                // Ativa imediatamente sem esperar abas fecharem
                return self.skipWaiting();
            })
            .catch((error) => {
                console.error('[SW] Erro no pré-cache:', error);
            })
    );
});

/**
 * ACTIVATE - Remove caches antigos
 */
self.addEventListener('activate', (event) => {
    console.log('[SW] Ativando Service Worker...');

    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((cacheName) => {
                            // Remove caches que não pertencem à versão atual
                            return cacheName.startsWith('mifire-') &&
                                   !cacheName.startsWith(CACHE_VERSION);
                        })
                        .map((cacheName) => {
                            console.log('[SW] Removendo cache antigo:', cacheName);
                            return caches.delete(cacheName);
                        })
                );
            })
            .then(() => {
                // Toma controle de todas as abas abertas
                return self.clients.claim();
            })
    );
});

/**
 * FETCH - Intercepta requisições
 */
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Ignora requisições não-GET
    if (request.method !== 'GET') return;

    // Ignora requisições para o painel admin de API
    if (url.pathname.startsWith('/api/')) return;

    // Ignora requisições do Chrome Extension e outros protocolos
    if (!url.protocol.startsWith('http')) return;

    // Estratégia baseada no tipo de recurso
    if (request.mode === 'navigate') {
        // PÁGINAS: Network-first com fallback para offline
        event.respondWith(networkFirstWithOfflineFallback(request));
    } else if (IMAGE_EXTENSIONS.test(url.pathname)) {
        // IMAGENS: Cache-first
        event.respondWith(cacheFirst(request, IMAGES_CACHE));
    } else if (STATIC_EXTENSIONS.test(url.pathname)) {
        // ASSETS ESTÁTICOS (CSS, JS, Fontes): Cache-first
        event.respondWith(cacheFirst(request, STATIC_CACHE));
    }
});

/**
 * Network-first com fallback para página offline
 * Ideal para conteúdo HTML que muda frequentemente
 */
async function networkFirstWithOfflineFallback(request) {
    try {
        const networkResponse = await fetch(request);

        // Cacheia a resposta se for bem-sucedida
        if (networkResponse.ok) {
            const cache = await caches.open(PAGES_CACHE);
            cache.put(request, networkResponse.clone());
        }

        return networkResponse;
    } catch (error) {
        // Tenta retornar do cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // Fallback: página offline
        const offlineResponse = await caches.match('/offline');
        if (offlineResponse) {
            return offlineResponse;
        }

        // Último recurso: resposta genérica de erro
        return new Response('Offline', {
            status: 503,
            statusText: 'Service Unavailable',
            headers: new Headers({ 'Content-Type': 'text/plain' }),
        });
    }
}

/**
 * Cache-first com fallback para rede
 * Ideal para assets estáticos que raramente mudam
 */
async function cacheFirst(request, cacheName) {
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
        return cachedResponse;
    }

    try {
        const networkResponse = await fetch(request);

        if (networkResponse.ok) {
            const cache = await caches.open(cacheName);
            cache.put(request, networkResponse.clone());
        }

        return networkResponse;
    } catch (error) {
        // Para imagens, retorna um placeholder transparente
        if (IMAGE_EXTENSIONS.test(request.url)) {
            return new Response(
                '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect fill="#1f2937" width="200" height="200"/><text fill="#6b7280" font-family="sans-serif" font-size="14" x="50%" y="50%" text-anchor="middle" dy=".3em">Offline</text></svg>',
                {
                    headers: { 'Content-Type': 'image/svg+xml' },
                }
            );
        }

        return new Response('', { status: 408 });
    }
}

/**
 * Listener para mensagens do app
 */
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }

    if (event.data && event.data.type === 'CLEAR_CACHE') {
        caches.keys().then((names) => {
            names.forEach((name) => caches.delete(name));
        });
    }
});
