@extends('site.layout')

@section('title', 'Nossos Produtos - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', 'Conheça a linha completa de produtos MiFire: extintores, sistemas de detecção e alarme, combate a incêndio e muito mais.')
@section('meta_keywords', 'produtos, extintores, combate incêndio, detecção alarme, MiFire')

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="relative bg-gray-900 py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <span class="inline-block text-red-400 text-sm font-bold uppercase tracking-widest mb-3">Catálogo</span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-4">Nossos Produtos</h1>
            <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>
            <p class="text-gray-400 text-lg mt-4 max-w-2xl mx-auto">Soluções completas em segurança contra incêndio para todos os segmentos.</p>
        </div>
    </section>

    {{-- ═══ CATEGORIES GRID ═══ --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">

            @if($categories->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        <a href="{{ route('products.category', $category->slug) }}"
                           class="fade-up group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 hover:-translate-y-2">
                            <div class="relative h-56 overflow-hidden bg-gray-100">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>

                                {{-- Product count badge --}}
                                <div class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $category->products_count ?? 0 }} {{ Str::plural('produto', $category->products_count ?? 0) }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">{{ $category->name }}</h2>
                                @if($category->description)
                                    <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $category->description }}</p>
                                @endif
                                <span class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-4 group-hover:gap-2 transition-all">
                                    Ver produtos
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="text-gray-500 text-lg">Nenhuma categoria de produto encontrada.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="py-16 bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 text-center fade-up">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Não encontrou o que procura?</h2>
            <p class="text-gray-400 mb-6">Entre em contato conosco para um atendimento personalizado.</p>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                Solicitar Orçamento
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

@endsection
