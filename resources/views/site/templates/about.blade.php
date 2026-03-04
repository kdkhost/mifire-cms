@extends('site.layout')

@section('title', $page->meta_title ?: $page->title . ' - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', $page->meta_description ?: 'Conheça a história, missão e valores da MiFire - referência em segurança contra incêndio.')
@section('meta_keywords', $page->meta_keywords ?? 'sobre, MiFire, empresa, segurança contra incêndio, história')

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="relative bg-gray-900 py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

        @if($page->featured_image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" class="w-full h-full object-cover opacity-20">
            </div>
        @endif

        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <span class="inline-block text-red-400 text-sm font-bold uppercase tracking-widest mb-3">Quem Somos</span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-4">{{ $page->title }}</h1>
            <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>

            <nav class="mt-6" aria-label="Breadcrumb">
                <ol class="flex items-center justify-center gap-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li class="text-white font-medium">{{ $page->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    {{-- ═══ COMPANY HISTORY ═══ --}}
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="fade-up space-y-6">
                    <div>
                        <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">Nossa História</span>
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight">
                            Tradição e <span class="text-red-600">inovação</span> em segurança
                        </h2>
                    </div>
                    <div class="prose prose-lg prose-gray prose-p:text-gray-600 prose-p:leading-relaxed prose-a:text-red-600 max-w-none">
                        {!! $page->content !!}
                    </div>
                </div>
                <div class="fade-up relative">
                    @if($page->featured_image)
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                            <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" class="w-full h-80 lg:h-[450px] object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/20 to-transparent"></div>
                        </div>
                    @else
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gradient-to-br from-red-600 to-red-800 h-80 lg:h-[450px] flex items-center justify-center">
                            <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    @endif
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-red-600 rounded-2xl -z-10 hidden lg:block"></div>
                    <div class="absolute -top-4 -left-4 w-16 h-16 bg-red-100 rounded-2xl -z-10 hidden lg:block"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ MISSION / VISION / VALUES ═══ --}}
    <section class="py-20 lg:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-14 fade-up">
                <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">Nossos Pilares</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900">Missão, Visão e <span class="text-red-600">Valores</span></h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Missão --}}
                <div class="fade-up bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                    <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Missão</h3>
                    <p class="text-gray-500 leading-relaxed">
                        {{ $settings->get('mission', 'Oferecer soluções completas e inovadoras em segurança contra incêndio, protegendo vidas e patrimônios com excelência, confiabilidade e compromisso com o cliente.') }}
                    </p>
                </div>

                {{-- Visão --}}
                <div class="fade-up bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group" style="transition-delay: 100ms">
                    <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Visão</h3>
                    <p class="text-gray-500 leading-relaxed">
                        {{ $settings->get('vision', 'Ser a empresa referência no mercado nacional de segurança contra incêndio, reconhecida pela qualidade dos produtos, inovação tecnológica e atendimento de excelência.') }}
                    </p>
                </div>

                {{-- Valores --}}
                <div class="fade-up bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group" style="transition-delay: 200ms">
                    <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Valores</h3>
                    <p class="text-gray-500 leading-relaxed">
                        {{ $settings->get('values', 'Ética, transparência, comprometimento com a qualidade, responsabilidade social, inovação contínua e respeito às pessoas e ao meio ambiente.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ FACTORY / HQ PHOTOS ═══ --}}
    <section class="py-20 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12 fade-up">
                <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">Estrutura</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900">Conheça nossa <span class="text-red-600">estrutura</span></h2>
                <p class="text-gray-500 text-lg mt-3 max-w-2xl mx-auto">Contamos com instalações modernas e equipadas para oferecer o melhor em segurança contra incêndio.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 fade-up" x-data="{ lightbox: false, currentImage: '' }">
                @php
                    $galleryImages = [
                        ['src' => 'images/about/factory-1.jpg', 'alt' => 'Fábrica MiFire - Produção'],
                        ['src' => 'images/about/factory-2.jpg', 'alt' => 'Fábrica MiFire - Qualidade'],
                        ['src' => 'images/about/factory-3.jpg', 'alt' => 'Sede MiFire - Escritório'],
                        ['src' => 'images/about/factory-4.jpg', 'alt' => 'Fábrica MiFire - Estoque'],
                        ['src' => 'images/about/factory-5.jpg', 'alt' => 'MiFire - Equipe'],
                        ['src' => 'images/about/factory-6.jpg', 'alt' => 'MiFire - Laboratório'],
                    ];
                @endphp

                @foreach($galleryImages as $index => $img)
                    <div
                        class="group relative rounded-xl overflow-hidden cursor-pointer {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}"
                        @click="currentImage = '{{ asset($img['src']) }}'; lightbox = true"
                    >
                        <img src="{{ asset($img['src']) }}" alt="{{ $img['alt'] }}" class="w-full h-full object-cover {{ $index === 0 ? 'min-h-[300px] md:min-h-[400px]' : 'h-48 md:h-52' }} group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gray-900/0 group-hover:bg-gray-900/40 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        </div>
                    </div>
                @endforeach

                {{-- Lightbox --}}
                <div
                    x-show="lightbox"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak
                    @click.self="lightbox = false"
                    @keydown.escape.window="lightbox = false"
                    class="fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-4"
                >
                    <button @click="lightbox = false" class="absolute top-4 right-4 text-white hover:text-red-400 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <img :src="currentImage" alt="Foto" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ TIMELINE ═══ --}}
    <section class="py-20 lg:py-28 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-14 fade-up">
                <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">Trajetória</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900">Nossa <span class="text-red-600">linha do tempo</span></h2>
            </div>

            <div class="relative">
                {{-- Timeline line --}}
                <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-red-200 md:-translate-x-0.5"></div>

                @php
                    $milestones = [
                        ['year' => '2005', 'title' => 'Fundação', 'desc' => 'A MiFire nasce com a missão de oferecer soluções inovadoras em segurança contra incêndio.'],
                        ['year' => '2008', 'title' => 'Expansão', 'desc' => 'Inauguração da primeira unidade fabril e ampliação do portfólio de produtos.'],
                        ['year' => '2012', 'title' => 'Certificações', 'desc' => 'Conquista das principais certificações do mercado, consolidando a qualidade dos produtos.'],
                        ['year' => '2016', 'title' => 'Parcerias Internacionais', 'desc' => 'Início das parcerias com marcas líderes mundiais como Notifier e 3M.'],
                        ['year' => '2020', 'title' => 'Inovação Tecnológica', 'desc' => 'Lançamento da tecnologia Dry-Flo® e novos sistemas inteligentes de combate a incêndio.'],
                        ['year' => '2024', 'title' => 'Liderança de Mercado', 'desc' => 'Reconhecida como referência nacional em soluções de segurança contra incêndio.'],
                    ];
                @endphp

                <div class="space-y-12">
                    @foreach($milestones as $index => $milestone)
                        <div class="fade-up relative flex items-start gap-6 md:gap-0 {{ $index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                            {{-- Dot --}}
                            <div class="absolute left-4 md:left-1/2 w-8 h-8 bg-red-600 rounded-full border-4 border-white shadow-md z-10 md:-translate-x-1/2 flex items-center justify-center -translate-x-1/2">
                                <div class="w-2 h-2 bg-white rounded-full"></div>
                            </div>

                            {{-- Content --}}
                            <div class="ml-10 md:ml-0 md:w-1/2 {{ $index % 2 === 0 ? 'md:pr-12 md:text-right' : 'md:pl-12' }}">
                                <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <span class="inline-block bg-red-100 text-red-600 text-sm font-bold px-3 py-1 rounded-full mb-3">{{ $milestone['year'] }}</span>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $milestone['title'] }}</h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">{{ $milestone['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="py-16 bg-red-600">
        <div class="max-w-4xl mx-auto px-4 text-center fade-up">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Quer saber mais sobre a MiFire?</h2>
            <p class="text-red-100 mb-6">Entre em contato com nossa equipe e conheça nossas soluções.</p>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-red-600 font-bold px-8 py-3.5 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                Fale Conosco
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

@endsection
