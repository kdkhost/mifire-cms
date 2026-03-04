@extends('site.layout')

@section('title', $settings->get('site_name', 'MiFire') . ' - Soluções em Segurança Contra Incêndio')
@section('meta_description', $settings->get('meta_description', 'MiFire - Soluções completas em segurança contra incêndio, extintores, detecção e alarme, combate a incêndios e muito mais.'))

@section('content')

    {{-- ═══ HERO SLIDER ═══ --}}
    <section
        x-data="{
            current: 0,
            banners: {{ $banners->count() }},
            autoplay: null,
            init() {
                this.startAutoplay();
            },
            startAutoplay() {
                this.autoplay = setInterval(() => { this.next() }, 6000);
            },
            stopAutoplay() {
                clearInterval(this.autoplay);
            },
            next() {
                this.current = (this.current + 1) % this.banners;
            },
            prev() {
                this.current = (this.current - 1 + this.banners) % this.banners;
            },
            goTo(index) {
                this.current = index;
                this.stopAutoplay();
                this.startAutoplay();
            }
        }"
        @mouseenter="stopAutoplay()"
        @mouseleave="startAutoplay()"
        class="relative w-full h-[500px] md:h-[600px] lg:h-[700px] overflow-hidden bg-gray-900"
    >
        @foreach($banners as $index => $banner)
            <div
                x-show="current === {{ $index }}"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 scale-105"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute inset-0"
            >
                {{-- Background Image --}}
                <div class="absolute inset-0">
                    @if($banner->image)
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 via-gray-900/50 to-transparent"></div>
                </div>

                {{-- Content --}}
                <div class="relative h-full max-w-7xl mx-auto px-4 flex items-center">
                    <div class="max-w-2xl space-y-5">
                        @if($banner->subtitle)
                            <span
                                x-show="current === {{ $index }}"
                                x-transition:enter="transition ease-out duration-500 delay-200"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="inline-block text-red-400 text-sm md:text-base font-semibold uppercase tracking-widest"
                            >
                                {{ $banner->subtitle }}
                            </span>
                        @endif

                        <h1
                            x-show="current === {{ $index }}"
                            x-transition:enter="transition ease-out duration-500 delay-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="text-3xl md:text-5xl lg:text-6xl font-black text-white leading-tight"
                        >
                            {{ $banner->title }}
                        </h1>

                        @if($banner->description)
                            <p
                                x-show="current === {{ $index }}"
                                x-transition:enter="transition ease-out duration-500 delay-400"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="text-gray-300 text-base md:text-lg leading-relaxed"
                            >
                                {{ $banner->description }}
                            </p>
                        @endif

                        @if($banner->button_text && $banner->button_url)
                            <div
                                x-show="current === {{ $index }}"
                                x-transition:enter="transition ease-out duration-500 delay-500"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                            >
                                <a href="{{ $banner->button_url }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm md:text-base">
                                    {{ $banner->button_text }}
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Navigation Arrows --}}
        @if($banners->count() > 1)
            <button @click="prev(); stopAutoplay(); startAutoplay()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/25 backdrop-blur-sm text-white rounded-full flex items-center justify-center transition-all duration-200 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="next(); stopAutoplay(); startAutoplay()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/25 backdrop-blur-sm text-white rounded-full flex items-center justify-center transition-all duration-200 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            {{-- Dots --}}
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
                @foreach($banners as $index => $banner)
                    <button
                        @click="goTo({{ $index }})"
                        :class="current === {{ $index }} ? 'bg-red-600 w-8' : 'bg-white/50 hover:bg-white/80 w-3'"
                        class="h-3 rounded-full transition-all duration-300"
                    ></button>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ═══ ABOUT SECTION ═══ --}}
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="fade-up space-y-6">
                    <div>
                        <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">Sobre a MiFire</span>
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 leading-tight">
                            Protegendo <span class="text-red-600">vidas</span> e patrimônios
                        </h2>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        {{ $settings->get('about_text', 'A MiFire é referência no mercado de segurança contra incêndio, oferecendo soluções completas e inovadoras para proteção de vidas e patrimônios. Com anos de experiência e uma equipe altamente qualificada, entregamos produtos e serviços de excelência.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ $settings->get('about_page_url', '/sobre-nos') }}" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-7 py-3.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                            Conheça Nossa História
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center gap-2 border-2 border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white font-bold px-7 py-3.5 rounded-lg transition-all duration-200">
                            Fale Conosco
                        </a>
                    </div>
                </div>
                <div class="fade-up relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="{{ $settings->get('about_image') ? asset('storage/' . $settings->get('about_image')) : asset('images/about-home.jpg') }}" alt="Sobre a MiFire" class="w-full h-80 lg:h-[450px] object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/30 to-transparent"></div>
                    </div>
                    {{-- Decorative accent --}}
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-red-600 rounded-2xl -z-10 hidden lg:block"></div>
                    <div class="absolute -top-4 -left-4 w-16 h-16 bg-red-100 rounded-2xl -z-10 hidden lg:block"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ SOLUTIONS SECTION ═══ --}}
    <section class="py-20 lg:py-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-14 fade-up">
                <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">O que fazemos</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900">Conheça nossas <span class="text-red-600">soluções</span></h2>
                <p class="text-gray-500 text-lg mt-4 max-w-2xl mx-auto">Oferecemos soluções integradas e personalizadas para proteção contra incêndio em diversos segmentos.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Card 1: Extintores --}}
                <a href="{{ route('products.index') }}?category=extintores" class="fade-up group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('images/solution-extintores.jpg') }}" alt="Extintores" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">Extintores</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Linha completa de extintores de incêndio para todos os tipos de ambientes e classes de fogo.</p>
                        <span class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-4 group-hover:gap-2 transition-all">
                            Saiba mais <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Card 2: Detecção e Alarme --}}
                <a href="{{ route('products.index') }}?category=deteccao-alarme" class="fade-up group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2" style="transition-delay: 100ms">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('images/solution-deteccao.jpg') }}" alt="Detecção e Alarme" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">Detecção e Alarme</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Sistemas inteligentes de detecção e alarme de incêndio com tecnologia de ponta Notifier.</p>
                        <span class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-4 group-hover:gap-2 transition-all">
                            Saiba mais <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Card 3: Sistemas de Combate --}}
                <a href="{{ route('products.index') }}?category=sistemas-combate" class="fade-up group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2" style="transition-delay: 200ms">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('images/solution-sistemas.jpg') }}" alt="Sistemas de Combate" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">Sistemas de Combate</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Projetos completos de sistemas fixos e automáticos de combate a incêndio com engenharia especializada.</p>
                        <span class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-4 group-hover:gap-2 transition-all">
                            Saiba mais <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══ BRANDS SECTION ═══ --}}
    @if($brands->count() > 0)
        <section class="py-20 lg:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12 fade-up">
                    <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">Parceiros</span>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900">Distribuidora <span class="text-red-600">Autorizada</span></h2>
                    <p class="text-gray-500 text-lg mt-3">Trabalhamos com as melhores marcas do mercado de segurança contra incêndio.</p>
                </div>

                <div class="fade-up grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center">
                    @foreach($brands as $brand)
                        <div class="group bg-gray-50 hover:bg-white rounded-xl p-6 flex items-center justify-center h-28 transition-all duration-300 hover:shadow-lg">
                            @if($brand->url)
                                <a href="{{ $brand->url }}" target="_blank" rel="noopener noreferrer" class="block">
                            @endif
                                @if($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="max-h-14 max-w-full object-contain grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100 transition-all duration-300" loading="lazy">
                                @else
                                    <span class="text-sm font-bold text-gray-400 group-hover:text-gray-900 transition-colors">{{ $brand->name }}</span>
                                @endif
                            @if($brand->url)
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ LATEST BLOG POSTS ═══ --}}
    @if($latestPosts->count() > 0)
        <section class="py-20 lg:py-28 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-12 gap-4 fade-up">
                    <div>
                        <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">Blog</span>
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900">Últimas <span class="text-red-600">Publicações</span></h2>
                    </div>
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 font-semibold transition-colors">
                        Ver todos os posts
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($latestPosts as $post)
                        <article class="fade-up group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                <div class="relative h-52 overflow-hidden">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                        </div>
                                    @endif
                                    @if($post->category)
                                        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $post->category->name }}</span>
                                    @endif
                                </div>
                            </a>
                            <div class="p-6">
                                <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $post->published_at?->format('d/m/Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        {{ number_format($post->views_count) }}
                                    </span>
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-2">{{ $post->title }}</h3>
                                </a>
                                @if($post->excerpt)
                                    <p class="text-gray-500 text-sm mt-2 line-clamp-3">{{ $post->excerpt }}</p>
                                @endif
                                <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-4 hover:gap-2 transition-all">
                                    Ler mais <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ CTA SECTION ═══ --}}
    <section class="relative py-20 lg:py-28 bg-gray-900 overflow-hidden">
        {{-- Decorative pattern --}}
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><defs><pattern id="cta-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white"/></pattern></defs><rect width="100" height="100" fill="url(#cta-pattern)"/></svg>
        </div>
        <div class="absolute top-0 left-0 w-96 h-96 bg-red-600/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-red-600/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

        <div class="relative max-w-4xl mx-auto px-4 text-center fade-up">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-5">
                Precisa de um orçamento <span class="text-red-500">personalizado?</span>
            </h2>
            <p class="text-gray-400 text-lg mb-8 max-w-2xl mx-auto">
                Nossa equipe de especialistas está pronta para atender suas necessidades em segurança contra incêndio. Entre em contato agora!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    Solicite um Orçamento
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                @if($settings->get('whatsapp'))
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->get('whatsapp')) }}?text={{ urlencode('Olá! Gostaria de solicitar um orçamento.') }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ ADDRESSES SECTION ═══ --}}
    @if($addresses->count() > 0)
        <section class="py-20 lg:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12 fade-up">
                    <span class="inline-block text-red-600 text-sm font-bold uppercase tracking-widest mb-2">Localização</span>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900">Nossas <span class="text-red-600">Unidades</span></h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-{{ min($addresses->count(), 3) }} gap-6">
                    @foreach($addresses as $address)
                        <div class="fade-up bg-gray-50 rounded-2xl p-6 hover:shadow-lg transition-all duration-300 border border-gray-100">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $address->label }}</h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">
                                        {{ $address->address }}
                                        @if($address->complement)<br>{{ $address->complement }}@endif
                                        <br>{{ $address->city }} - {{ $address->state }}
                                        @if($address->zip_code)<br>CEP: {{ $address->zip_code }}@endif
                                    </p>
                                    @if($address->phone)
                                        <a href="tel:{{ $address->phone }}" class="inline-flex items-center gap-2 text-red-600 font-medium text-sm mt-3 hover:text-red-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $address->phone }}
                                        </a>
                                    @endif
                                    @if($address->phone2)
                                        <a href="tel:{{ $address->phone2 }}" class="inline-flex items-center gap-2 text-gray-500 text-sm mt-1 hover:text-red-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $address->phone2 }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
