@extends('site.layout')

@section('title', $page->meta_title ?: $page->title . ' - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', $page->meta_description ?: 'Conheça a tecnologia exclusiva Dry-Flo® da MiFire. Extinção de incêndio por agente limpo.')
@if($page->meta_keywords)
    @section('meta_keywords', $page->meta_keywords)
@endif

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="relative bg-gray-900 py-24 lg:py-36 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 50px 50px;"></div>
        </div>
        {{-- Gradient Blobs --}}
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-red-600/20 rounded-full blur-3xl -translate-y-1/2 -translate-x-1/2"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-red-600/10 rounded-full blur-3xl translate-y-1/2 translate-x-1/2"></div>

        @if($page->featured_image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" class="w-full h-full object-cover opacity-20">
            </div>
        @endif

        <div class="relative max-w-5xl mx-auto px-4 text-center">
            <div class="inline-flex items-center gap-2 bg-red-600/20 text-red-400 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Tecnologia Exclusiva
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight">
                Dry-Flo<sup class="text-red-500 text-2xl">®</sup>
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                Sistema avançado de combate a incêndio por agente limpo. Proteção sem resíduos, sem danos, sem interrupções.
            </p>
            <div class="w-24 h-1 bg-red-600 mx-auto rounded-full mt-8"></div>
        </div>
    </section>

    {{-- ═══ WHAT IS DRY-FLO ═══ --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="fade-up">
                    <span class="text-red-600 text-sm font-bold uppercase tracking-widest">O que é</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-6">
                        Tecnologia Dry-Flo<sup class="text-red-600 text-lg">®</sup>
                    </h2>
                    <div class="prose prose-lg text-gray-600 max-w-none">
                        {!! $page->content !!}
                    </div>
                </div>

                <div class="fade-up">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-red-100 rounded-3xl transform rotate-3"></div>
                        @if($page->featured_image)
                            <img src="{{ asset('storage/' . $page->featured_image) }}" alt="Tecnologia Dry-Flo" class="relative rounded-2xl shadow-xl w-full" loading="lazy">
                        @else
                            <div class="relative bg-gradient-to-br from-red-600 to-red-800 rounded-2xl shadow-xl aspect-video flex items-center justify-center">
                                <div class="text-center text-white p-8">
                                    <svg class="w-20 h-20 mx-auto mb-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <p class="text-xl font-bold">Dry-Flo<sup>®</sup></p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ BENEFITS ═══ --}}
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-14 fade-up">
                <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Vantagens</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">Por que escolher Dry-Flo<sup class="text-red-600 text-lg">®</sup>?</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Conheça os benefícios exclusivos que tornam o Dry-Flo® a solução ideal para proteção contra incêndio</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 fade-up">
                {{-- Benefit 1 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:border-red-200 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Sem Resíduos</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Agente limpo que evapora completamente, sem deixar resíduos que possam danificar equipamentos ou documentos.</p>
                </div>

                {{-- Benefit 2 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:border-red-200 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Resposta Rápida</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Ativação em segundos com supressão imediata do fogo, minimizando danos e tempo de inatividade.</p>
                </div>

                {{-- Benefit 3 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:border-red-200 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Ecologicamente Seguro</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Zero impacto na camada de ozônio (ODP = 0) e baixo potencial de aquecimento global (GWP).</p>
                </div>

                {{-- Benefit 4 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:border-red-200 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zm4-12v4m0 0H7m4 0h4"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Proteção para TI</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Ideal para data centers, salas de servidores e centrais de telecomunicações sem risco aos equipamentos.</p>
                </div>

                {{-- Benefit 5 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:border-red-200 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Seguro para Pessoas</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Agente não tóxico em concentrações de projeto, permitindo presença humana em áreas protegidas.</p>
                </div>

                {{-- Benefit 6 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:border-red-200 hover:shadow-lg transition-all duration-300 group">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Normas Internacionais</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Em conformidade com NFPA 2001 e normas ABNT, garantindo qualidade e confiabilidade certificada.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ HOW IT WORKS ═══ --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-14 fade-up">
                <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Funcionamento</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">Como o Dry-Flo<sup class="text-red-600 text-lg">®</sup> funciona</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Um processo automatizado em etapas que garante proteção completa</p>
            </div>

            <div class="grid md:grid-cols-4 gap-6 fade-up">
                {{-- Step 1 --}}
                <div class="relative text-center group">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black mx-auto mb-5 group-hover:scale-110 transition-transform">1</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Detecção</h3>
                    <p class="text-gray-500 text-sm">Sensores inteligentes identificam fumaça, calor ou chama em estágio inicial</p>
                    {{-- Arrow --}}
                    <div class="hidden md:block absolute top-8 left-full w-full -translate-x-1/2">
                        <svg class="w-full h-6 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 100 24"><path stroke-width="2" d="M0 12h80M80 12l-8-8M80 12l-8 8"/></svg>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="relative text-center group">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black mx-auto mb-5 group-hover:scale-110 transition-transform">2</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Alarme</h3>
                    <p class="text-gray-500 text-sm">Sistema de alarme é ativado automaticamente, alertando ocupantes para evacuação</p>
                    <div class="hidden md:block absolute top-8 left-full w-full -translate-x-1/2">
                        <svg class="w-full h-6 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 100 24"><path stroke-width="2" d="M0 12h80M80 12l-8-8M80 12l-8 8"/></svg>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="relative text-center group">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black mx-auto mb-5 group-hover:scale-110 transition-transform">3</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Descarga</h3>
                    <p class="text-gray-500 text-sm">Agente limpo gasoso é liberado em segundos, atingindo toda a área protegida</p>
                    <div class="hidden md:block absolute top-8 left-full w-full -translate-x-1/2">
                        <svg class="w-full h-6 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 100 24"><path stroke-width="2" d="M0 12h80M80 12l-8-8M80 12l-8 8"/></svg>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="relative text-center group">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black mx-auto mb-5 group-hover:scale-110 transition-transform">4</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Extinção</h3>
                    <p class="text-gray-500 text-sm">Incêndio suprimido sem resíduos. Retorno imediato à operação normal</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ APPLICATIONS ═══ --}}
    <section class="py-16 lg:py-24 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-14 fade-up">
                <span class="text-red-400 text-sm font-bold uppercase tracking-widest">Aplicações</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mt-2 mb-4">Onde utilizar o Dry-Flo<sup class="text-red-500 text-lg">®</sup></h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Ideal para ambientes onde água ou pó químico causariam mais danos que o próprio incêndio</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-up">
                @php
                    $applications = [
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zm4-12v4m0 0H7m4 0h4"/>', 'title' => 'Data Centers', 'desc' => 'Servidores e equipamentos de TI'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>', 'title' => 'Escritórios', 'desc' => 'Áreas administrativas e comerciais'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4"/>', 'title' => 'Museus', 'desc' => 'Acervos e obras de arte'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>', 'title' => 'Laboratórios', 'desc' => 'Ambientes de pesquisa e análise'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'title' => 'Bancos', 'desc' => 'Cofres e áreas de segurança'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'title' => 'Telecom', 'desc' => 'Centrais de telecomunicações'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>', 'title' => 'Hospitais', 'desc' => 'Salas de operação e UTIs'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>', 'title' => 'Mídias', 'desc' => 'Estúdios e salas de controle'],
                    ];
                @endphp

                @foreach($applications as $app)
                    <div class="bg-gray-800/60 rounded-2xl p-6 border border-gray-700 hover:border-red-600/50 hover:bg-gray-800 transition-all duration-300 group text-center">
                        <div class="w-12 h-12 bg-red-600/20 text-red-400 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-red-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $app['icon'] !!}</svg>
                        </div>
                        <h3 class="font-bold text-white mb-1">{{ $app['title'] }}</h3>
                        <p class="text-gray-400 text-sm">{{ $app['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ VIDEO / DEMO SECTION ═══ --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12 fade-up">
                <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Demonstração</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">Veja o Dry-Flo<sup class="text-red-600 text-lg">®</sup> em ação</h2>
            </div>

            <div class="fade-up">
                <div class="relative bg-gray-100 rounded-2xl overflow-hidden aspect-video border border-gray-200 group">
                    {{-- Video placeholder - replace src with actual YouTube/Vimeo embed --}}
                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-900 to-gray-800" x-data="{ playing: false }">
                        <template x-if="!playing">
                            <button @click="playing = true" class="relative z-10 w-20 h-20 bg-red-600 hover:bg-red-700 rounded-full flex items-center justify-center transition-all shadow-2xl shadow-red-600/30 group-hover:scale-110">
                                <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                        </template>
                        <template x-if="playing">
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <p class="text-lg">Vídeo em breve</p>
                            </div>
                        </template>
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 text-white">
                            <p class="text-xs text-red-400 font-bold uppercase tracking-wider">Vídeo Demonstrativo</p>
                            <p class="text-lg font-bold">Sistema Dry-Flo® em operação</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ SPECS TABLE ═══ --}}
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12 fade-up">
                <span class="text-red-600 text-sm font-bold uppercase tracking-widest">Especificações</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2 mb-4">Dados Técnicos</h2>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden fade-up">
                <table class="w-full">
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $specs = [
                                ['Agente Supressor', 'FK-5-1-12 (Novec™ 1230)'],
                                ['ODP (Potencial de Depleção de Ozônio)', '0'],
                                ['GWP (Potencial de Aquecimento Global)', '< 1'],
                                ['Tempo de Vida Atmosférico', '5 dias'],
                                ['Margem de Segurança (NOAEL)', '10%'],
                                ['Tempo de Descarga', '< 10 segundos'],
                                ['Pressão de Trabalho', '25 bar / 42 bar'],
                                ['Temperatura de Operação', '-20°C a 50°C'],
                                ['Normas Aplicáveis', 'NFPA 2001 / ISO 14520 / ABNT'],
                                ['Classificação de Incêndio', 'Classes A, B e C'],
                            ];
                        @endphp

                        @foreach($specs as $i => $spec)
                            <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-red-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $spec[0] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 text-right">{{ $spec[1] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="py-16 lg:py-24 bg-red-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 30px 30px;"></div>
        </div>
        <div class="absolute top-0 right-0 w-80 h-80 bg-red-800 rounded-full blur-3xl opacity-30 translate-x-1/2 -translate-y-1/2"></div>

        <div class="relative max-w-4xl mx-auto px-4 text-center fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Proteja seu patrimônio com Dry-Flo<sup>®</sup></h2>
            <p class="text-red-100 text-lg mb-8 max-w-2xl mx-auto">Solicite um projeto personalizado para sua empresa. Nossos engenheiros estão prontos para dimensionar a melhor solução.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.index') }}?product=Dry-Flo" class="inline-flex items-center justify-center gap-2 bg-white text-red-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-bold transition-all shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Solicitar Orçamento
                </a>
                @if($settings->get('whatsapp'))
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->get('whatsapp')) }}?text={{ urlencode('Olá! Gostaria de saber mais sobre o sistema Dry-Flo®.') }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-red-700 hover:bg-red-800 text-white px-8 py-4 rounded-lg font-bold transition-all border border-red-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        Falar pelo WhatsApp
                    </a>
                @endif
            </div>
        </div>
    </section>

@endsection
