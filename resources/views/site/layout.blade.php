<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>@yield('title', $settings->get('site_name', 'MiFire - Segurança Contra Incêndio'))</title>
    <meta name="description" content="@yield('meta_description', $settings->get('meta_description', 'MiFire - Soluções em segurança contra incêndio e combate a incêndios.'))">
    <meta name="keywords" content="@yield('meta_keywords', $settings->get('meta_keywords', 'extintores, combate a incêndio, segurança contra incêndio, MiFire'))">
    <meta name="author" content="MiFire">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', $settings->get('site_name', 'MiFire'))">
    <meta property="og:description" content="@yield('og_description', $settings->get('meta_description', ''))">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="{{ $settings->get('site_name', 'MiFire') }}">

    {{-- PWA Meta --}}
    <meta name="theme-color" content="{{ $settings->get('theme_color', '#dc2626') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $settings->get('site_name', 'MiFire') }}">
    <link rel="manifest" href="/manifest.json">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ $settings->get('site_favicon') ? asset('storage/' . $settings->get('site_favicon')) : asset('pwa/icons/icon-72x72.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('pwa/icons/icon-192x192.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Additional Head --}}
    @stack('head')

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }

        /* Scroll animations */
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        .fade-in { opacity: 0; transition: opacity 0.7s ease-out; }
        .fade-in.visible { opacity: 1; }
        .slide-left { opacity: 0; transform: translateX(-30px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
        .slide-left.visible { opacity: 1; transform: translateX(0); }
        .slide-right { opacity: 0; transform: translateX(30px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
        .slide-right.visible { opacity: 1; transform: translateX(0); }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #b91c1c; }
    </style>
    {{-- CSS Personalizado (definido nas config. avançadas do admin) --}}
    @if($settings->get('custom_css'))
        <style>{!! $settings->get('custom_css') !!}</style>
    @endif

    {{-- Scripts no <head> (Google Analytics, GTM, etc.) --}}
    @if($settings->get('head_scripts'))
        {!! $settings->get('head_scripts') !!}
    @endif
</head>
<body class="bg-white text-gray-800 antialiased" x-data="{ mobileMenu: false }">

    {{-- ═══ TOP BAR ═══ --}}
    <div class="bg-gray-900 text-gray-300 text-xs py-2 hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center gap-6">
                @if($settings->get('phone'))
                    <a href="tel:{{ $settings->get('phone') }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $settings->get('phone') }}
                    </a>
                @endif
                @if($settings->get('phone2'))
                    <a href="tel:{{ $settings->get('phone2') }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $settings->get('phone2') }}
                    </a>
                @endif
                @if($settings->get('email'))
                    <a href="mailto:{{ $settings->get('email') }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $settings->get('email') }}
                    </a>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @foreach($socialLinks as $social)
                    <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors" title="{{ $social->platform }}">
                        @if($social->icon && (Str::contains($social->icon, '.') || Str::startsWith($social->icon, 'http')))
                            <img src="{{ Str::startsWith($social->icon, 'http') ? $social->icon : asset('storage/' . $social->icon) }}" alt="{{ $social->platform }}" class="w-4 h-4 opacity-70 hover:opacity-100 transition-opacity" loading="lazy">
                        @elseif($social->icon)
                            <i class="{{ $social->icon }} w-4 h-4 flex items-center justify-center opacity-70 hover:opacity-100 transition-opacity"></i>
                        @else
                            @switch(strtolower($social->platform))
                                @case('facebook')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    @break
                                @case('instagram')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    @break
                                @case('linkedin')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    @break
                                @case('youtube')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/><path fill="#fff" d="M9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    @break
                                @default
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            @endswitch
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══ MAIN NAVIGATION ═══ --}}
    <header
        x-data="{ scrolled: false }"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
        :class="scrolled ? 'bg-white shadow-lg' : 'bg-white/95 backdrop-blur-md'"
        class="sticky top-0 z-50 transition-all duration-300"
    >
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16 lg:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    @if($settings->get('site_logo'))
                        <img src="{{ asset('storage/' . $settings->get('site_logo')) }}" alt="{{ $settings->get('site_name', 'MiFire') }}" class="h-10 lg:h-14 w-auto">
                    @else
                        <span class="text-2xl lg:text-3xl font-black">
                            <span class="text-gray-900">Mi</span><span class="text-red-600">Fire</span>
                        </span>
                    @endif
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden lg:flex items-center gap-1">
                    @foreach($menus as $menu)
                        @if($menu->children->count() > 0)
                            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                                <a href="{{ $menu->url ?? ($menu->page ? route('page.show', $menu->page->slug) : '#') }}"
                                   class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-700 hover:text-red-600 rounded-lg transition-colors {{ request()->url() === url($menu->url ?? '') ? 'text-red-600' : '' }}"
                                >
                                    {{ $menu->title }}
                                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </a>
                                <div
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    x-cloak
                                    class="absolute left-0 top-full mt-1 w-56 bg-white rounded-xl shadow-xl ring-1 ring-gray-100 py-2 z-50"
                                >
                                    @foreach($menu->children as $child)
                                        <a href="{{ $child->url ?? ($child->page ? route('page.show', $child->page->slug) : '#') }}"
                                           target="{{ $child->target ?? '_self' }}"
                                           class="block px-4 py-2.5 text-sm text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors"
                                        >
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url ?? ($menu->page ? route('page.show', $menu->page->slug) : '#') }}"
                               target="{{ $menu->target ?? '_self' }}"
                               class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-red-600 rounded-lg transition-colors {{ request()->url() === url($menu->url ?? '') ? 'text-red-600 font-semibold' : '' }}"
                            >
                                {{ $menu->title }}
                            </a>
                        @endif
                    @endforeach
                </nav>

                {{-- CTA + Mobile Toggle --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('contact.index') }}" class="hidden lg:inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                        Orçamento
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>

                    {{-- Mobile Menu Button --}}
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div
            x-show="mobileMenu"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            x-cloak
            class="lg:hidden border-t border-gray-100 bg-white shadow-xl"
        >
            <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
                @foreach($menus as $menu)
                    @if($menu->children->count() > 0)
                        <div x-data="{ subOpen: false }">
                            <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors">
                                {{ $menu->title }}
                                <svg class="w-4 h-4 transition-transform" :class="subOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="subOpen" x-collapse x-cloak class="ml-4 space-y-1">
                                @foreach($menu->children as $child)
                                    <a href="{{ $child->url ?? ($child->page ? route('page.show', $child->page->slug) : '#') }}"
                                       class="block px-4 py-2.5 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                       @click="mobileMenu = false"
                                    >
                                        {{ $child->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->url ?? ($menu->page ? route('page.show', $menu->page->slug) : '#') }}"
                           class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors {{ request()->url() === url($menu->url ?? '') ? 'text-red-600 bg-red-50' : '' }}"
                           @click="mobileMenu = false"
                        >
                            {{ $menu->title }}
                        </a>
                    @endif
                @endforeach

                <div class="pt-3 border-t border-gray-100">
                    <a href="{{ route('contact.index') }}" class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-3 rounded-lg transition-all">
                        Solicitar Orçamento
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                {{-- Mobile contact info --}}
                <div class="pt-3 border-t border-gray-100 space-y-2">
                    @if($settings->get('phone'))
                        <a href="tel:{{ $settings->get('phone') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $settings->get('phone') }}
                        </a>
                    @endif
                    @if($settings->get('email'))
                        <a href="mailto:{{ $settings->get('email') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $settings->get('email') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                {{-- Col 1: Logo e Texto --}}
                <div class="space-y-6">
                    <a href="{{ route('home') }}" class="inline-block transform hover:scale-105 transition-transform duration-300">
                        @if($settings->get('logo_white'))
                            <img src="{{ asset('storage/' . $settings->get('logo_white')) }}" alt="MiFire" class="h-14 w-auto drop-shadow-lg">
                        @else
                            <span class="text-white font-black text-3xl tracking-tighter flex items-center gap-2">
                                <span class="bg-red-600 px-2 py-0.5 rounded-sm italic">MI</span>FIRE
                            </span>
                        @endif
                    </a>
                    <p class="text-sm leading-relaxed text-gray-400">
                        {{ $settings->get('company_description', 'Soluções completas em segurança contra incêndio e equipamentos de combate a incêndios. Qualidade, confiança e inovação para proteger vidas e patrimônios.') }}
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        @foreach($socialLinks as $social)
                            <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition-all duration-200 group"
                               title="{{ $social->platform }}">
                                @if($social->icon)
                                    <i class="{{ $social->icon }} text-lg opacity-70 group-hover:opacity-100"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Col 2: Endereços --}}
                @php
                    $physicalAddresses = $addresses->filter(fn($a) => $a->is_active);
                    $departmentsJson = $settings->get('contact_departments', '[]');
                    $contactDepts = json_decode($departmentsJson, true) ?: [];
                @endphp

                <div>
                    <h3 class="text-white font-bold text-lg mb-6 uppercase tracking-widest text-gray-400">Endereços</h3>
                    <div class="space-y-8 text-sm">
                        @foreach($physicalAddresses as $address)
                            <div class="space-y-2">
                                <h4 class="text-white font-bold mb-1 uppercase">{{ $address->label }}</h4>
                                <p class="text-gray-400 leading-relaxed uppercase">
                                    {{ $address->address }}<br>
                                    @if($address->complement){{ $address->complement }} - @endif
                                    {{ $address->city }} - {{ $address->state }} @if($address->zip_code)- CEP: {{ $address->zip_code }}@endif
                                </p>
                                @if($address->phone)
                                    <div class="text-red-500 font-bold mt-2">
                                        {{ $address->phone }}
                                    </div>
                                @endif
                                @if($address->phone2)
                                    <div class="text-red-500 font-bold">
                                        {{ $address->phone2 }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Col 3: Fale Conosco --}}
                <div>
                    <h3 class="text-white font-bold text-lg mb-6 uppercase tracking-widest text-gray-400">Fale Conosco</h3>
                    <div class="space-y-6 text-sm">
                        @foreach($contactDepts as $dept)
                            <div class="space-y-2">
                                <h4 class="text-white font-bold mb-2 uppercase">{{ $dept['name'] }}</h4>
                                <div class="space-y-1.5 text-gray-300">
                                    @if(isset($dept['phones']) && $dept['phones'])
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-phone text-red-600 mt-1"></i>
                                            <span class="text-[13px] tracking-wider">{{ $dept['phones'] }}</span>
                                        </div>
                                    @endif
                                    @if(isset($dept['whatsapp']) && $dept['whatsapp'])
                                        <div class="flex items-start gap-3">
                                            <i class="fab fa-whatsapp text-green-500 mt-1"></i>
                                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $dept['whatsapp']) }}" target="_blank" class="hover:text-white transition-colors text-[13px]">{{ $dept['whatsapp'] }}</a>
                                        </div>
                                    @endif
                                    @if(isset($dept['email']) && $dept['email'])
                                        <div class="flex items-start gap-3 mt-1">
                                            <i class="fas fa-envelope text-red-600 mt-1"></i>
                                            <a href="mailto:{{ $dept['email'] }}" class="hover:text-white transition-colors text-[11px] uppercase tracking-wide truncate max-w-[180px]">{{ $dept['email'] }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Col 4: Links Rápidos --}}
                <div>
                    <h3 class="text-white font-bold text-lg mb-6 uppercase tracking-widest text-gray-400">Links Rápidos</h3>
                    <ul class="space-y-3 text-sm">
                        @foreach($footerMenus as $fMenu)
                            <li><a href="{{ $fMenu->url ?? ($fMenu->page ? route('page.show', $fMenu->page->slug) : '#') }}" class="text-gray-400 hover:text-white transition-colors">{{ $fMenu->title }}</a></li>
                        @endforeach
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white transition-colors">Produtos</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="{{ route('downloads.index') }}" class="text-gray-400 hover:text-white transition-colors">Downloads</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-gray-400 hover:text-white transition-colors">Contato</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Copyright Bar --}}
        <div class="border-t border-gray-800 bg-black/10">
            <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} MiFire. Todos os direitos reservados.</p>
                <p>
                    Desenvolvido por
                    <a href="https://kdkhost.com.br" target="_blank" rel="noopener noreferrer" class="text-red-900 hover:text-red-700 transition-colors font-medium">
                        George Marcelo - KDKHost Soluções
                    </a>
                </p>
            </div>
        </div>
    </footer>

    {{-- ═══ WhatsApp Float Button ═══ --}}
    @if($settings->get('whatsapp'))
        <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->get('whatsapp')) }}?text={{ urlencode($settings->get('whatsapp_message', 'Olá! Gostaria de mais informações.')) }}"
           target="_blank"
           rel="noopener noreferrer"
           class="fixed bottom-6 right-6 z-40 w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 group"
           title="Fale conosco pelo WhatsApp"
        >
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            <span class="absolute right-full mr-3 bg-white text-gray-800 text-sm font-medium px-3 py-1.5 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                Fale conosco!
            </span>
        </a>
    @endif

    {{-- ═══ Scroll to Top Button ═══ --}}
    <button
        x-data="{ show: false }"
        x-init="window.addEventListener('scroll', () => { show = window.scrollY > 500 })"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        x-cloak
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 left-6 z-40 w-12 h-12 bg-gray-900 hover:bg-red-600 text-white rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110"
        title="Voltar ao topo"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
    </button>

    {{-- ═══ PWA Service Worker ═══ --}}
    @if($pwaEnabled)
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then(reg => console.log('SW registered:', reg.scope))
                        .catch(err => console.log('SW registration failed:', err));
                });
            }

            // PWA Install Prompt
            let deferredPrompt;
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                const installBanner = document.getElementById('pwa-install-banner');
                if (installBanner) installBanner.classList.remove('hidden');
            });

            function installPWA() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('PWA installed');
                        }
                        deferredPrompt = null;
                        const installBanner = document.getElementById('pwa-install-banner');
                        if (installBanner) installBanner.classList.add('hidden');
                    });
                }
            }
        </script>
    @endif

    {{-- Scroll Animation Observer --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('.fade-up, .fade-in, .slide-left, .slide-right').forEach(el => {
                observer.observe(el);
            });
        });
    </script>

    @stack('scripts')

    {{-- Scripts antes do </body> (chat widgets, analytics, etc.) --}}
    @if($settings->get('body_scripts'))
        {!! $settings->get('body_scripts') !!}
    @endif
</body>
</html>
