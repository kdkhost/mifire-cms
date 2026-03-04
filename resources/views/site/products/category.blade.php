@extends('site.layout')

@section('title', $category->name . ' - Produtos - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', $category->description ?: 'Confira os produtos da categoria ' . $category->name . ' da MiFire.')

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="relative bg-gray-900 py-16 lg:py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        @if($category->image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover opacity-15">
            </div>
        @endif

        <div class="relative max-w-7xl mx-auto px-4">
            {{-- Breadcrumb --}}
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Produtos</a></li>
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li class="text-white font-medium">{{ $category->name }}</li>
                </ol>
            </nav>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-3">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-400 text-lg max-w-3xl">{{ $category->description }}</p>
            @endif
        </div>
    </section>

    {{-- ═══ PRODUCTS + SIDEBAR ═══ --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-10">

                {{-- Sidebar: Categories --}}
                <aside class="lg:w-64 flex-shrink-0">
                    <div class="sticky top-24 space-y-6">
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Categorias</h3>
                            <ul class="space-y-1">
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('products.category', $cat->slug) }}"
                                           class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm transition-colors {{ $cat->slug === $category->slug ? 'bg-red-600 text-white font-semibold' : 'text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                                            <span>{{ $cat->name }}</span>
                                            <span class="text-xs {{ $cat->slug === $category->slug ? 'text-red-200' : 'text-gray-400' }}">{{ $cat->products_count ?? 0 }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- CTA --}}
                        <div class="bg-red-600 rounded-2xl p-6 text-white">
                            <h3 class="font-bold text-lg mb-2">Precisa de ajuda?</h3>
                            <p class="text-red-100 text-sm mb-4">Nossa equipe pode ajudá-lo a escolher o produto ideal.</p>
                            <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-white text-red-600 font-bold text-sm px-4 py-2.5 rounded-lg hover:bg-gray-100 transition-colors">
                                Fale Conosco
                            </a>
                        </div>
                    </div>
                </aside>

                {{-- Products Grid --}}
                <div class="flex-1">
                    @if($products->count() > 0)
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <a href="{{ route('products.show', [$category->slug, $product->slug]) }}"
                                   class="fade-up group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                    <div class="relative h-52 overflow-hidden bg-gray-100">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded-full">Destaque</span>
                                        @endif
                                    </div>
                                    <div class="p-5">
                                        <h3 class="text-base font-bold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-2">{{ $product->name }}</h3>
                                        @if($product->short_description)
                                            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $product->short_description }}</p>
                                        @endif
                                        <span class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-3 group-hover:gap-2 transition-all">
                                            Ver detalhes
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-10">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <p class="text-gray-500 text-lg">Nenhum produto encontrado nesta categoria.</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-red-600 font-semibold mt-4 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                                Voltar para categorias
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection
