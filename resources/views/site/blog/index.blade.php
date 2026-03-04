@extends('site.layout')

@section('title', 'Blog - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', 'Acompanhe as novidades, dicas e artigos sobre segurança contra incêndio no blog da MiFire.')
@section('meta_keywords', 'blog, artigos, notícias, segurança contra incêndio, MiFire')

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="relative bg-gray-900 py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <span class="inline-block text-red-400 text-sm font-bold uppercase tracking-widest mb-3">Novidades</span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-4">Blog Mi<span class="text-red-500">Fire</span></h1>
            <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>
            <p class="text-gray-400 text-lg mt-4 max-w-2xl mx-auto">Artigos, dicas e novidades sobre segurança contra incêndio.</p>
        </div>
    </section>

    {{-- ═══ CATEGORY FILTER TABS ═══ --}}
    @if($categories->count() > 0)
        <section class="bg-white border-b border-gray-100 sticky top-16 lg:top-20 z-30">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center gap-2 overflow-x-auto py-4 scrollbar-none">
                    <a href="{{ route('blog.index') }}"
                       class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-all {{ !request('category') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                        Todos
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                           class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-all {{ request('category') === $cat->slug ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                            {{ $cat->name }}
                            <span class="text-xs ml-1 opacity-70">({{ $cat->blog_posts_count ?? 0 }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ POSTS + SIDEBAR ═══ --}}
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-10">

                {{-- Posts Grid --}}
                <div class="flex-1">
                    @if($posts->count() > 0)
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($posts as $post)
                                <article class="fade-up group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                        <div class="relative h-48 overflow-hidden">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                                </div>
                                            @endif
                                            @if($post->category)
                                                <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $post->category->name }}</span>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="p-5">
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
                                            <h2 class="text-base font-bold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-2">{{ $post->title }}</h2>
                                        </a>
                                        @if($post->excerpt)
                                            <p class="text-gray-500 text-sm mt-2 line-clamp-3">{{ $post->excerpt }}</p>
                                        @endif
                                        <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-3 hover:gap-2 transition-all">
                                            Ler mais <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-10">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="text-center py-16 bg-white rounded-2xl">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <p class="text-gray-500 text-lg">Nenhum post encontrado.</p>
                            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-red-600 font-semibold mt-4 hover:text-red-700">
                                Ver todos os posts
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="lg:w-80 flex-shrink-0">
                    <div class="sticky top-36 space-y-6">

                        {{-- Categories --}}
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Categorias</h3>
                            <ul class="space-y-1">
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                                           class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm transition-colors {{ request('category') === $cat->slug ? 'bg-red-600 text-white font-semibold' : 'text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                                            <span>{{ $cat->name }}</span>
                                            <span class="text-xs {{ request('category') === $cat->slug ? 'text-red-200' : 'text-gray-400' }}">{{ $cat->blog_posts_count ?? 0 }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Downloads / eBooks --}}
                        <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-2xl p-6 text-white">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="font-bold text-lg mb-2">Downloads</h3>
                            <p class="text-red-100 text-sm mb-4">Acesse manuais, catálogos e materiais técnicos gratuitamente.</p>
                            <a href="{{ route('downloads.index') }}" class="inline-flex items-center gap-2 bg-white text-red-600 font-bold text-sm px-4 py-2.5 rounded-lg hover:bg-gray-100 transition-colors">
                                Ver Downloads
                            </a>
                        </div>

                        {{-- Recent Posts --}}
                        @if($posts->count() > 0)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Posts Recentes</h3>
                                <div class="space-y-4">
                                    @foreach($posts->take(5) as $recentPost)
                                        <a href="{{ route('blog.show', $recentPost->slug) }}" class="flex items-start gap-3 group">
                                            <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                                @if($recentPost->featured_image)
                                                    <img src="{{ asset('storage/' . $recentPost->featured_image) }}" alt="{{ $recentPost->title }}" class="w-full h-full object-cover" loading="lazy">
                                                @else
                                                    <div class="w-full h-full bg-red-100 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-2">{{ $recentPost->title }}</h4>
                                                <span class="text-xs text-gray-400 mt-1 block">{{ $recentPost->published_at?->format('d/m/Y') }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </aside>
            </div>
        </div>
    </section>

@endsection
