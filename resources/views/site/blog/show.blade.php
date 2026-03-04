@extends('site.layout')

@section('title', ($post->meta_title ?: $post->title) . ' - Blog - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 160)))
@section('og_title', $post->title)
@section('og_description', $post->excerpt ?? '')
@section('og_image', $post->featured_image ? asset('storage/' . $post->featured_image) : '')

@section('content')

    {{-- ═══ FEATURED IMAGE HERO ═══ --}}
    <section class="relative bg-gray-900 overflow-hidden {{ $post->featured_image ? 'h-[350px] md:h-[450px]' : 'py-20 lg:py-28' }}">
        @if($post->featured_image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-gray-900/30"></div>
            </div>
        @else
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
            </div>
        @endif

        <div class="relative h-full max-w-4xl mx-auto px-4 flex items-end pb-10">
            <div>
                {{-- Breadcrumb --}}
                <nav class="mb-4" aria-label="Breadcrumb">
                    <ol class="flex flex-wrap items-center gap-2 text-sm text-gray-300">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog</a></li>
                        @if($post->category)
                            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                            <li><a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="hover:text-white transition-colors">{{ $post->category->name }}</a></li>
                        @endif
                    </ol>
                </nav>

                @if($post->category)
                    <span class="inline-block bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">{{ $post->category->name }}</span>
                @endif

                <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-white leading-tight">{{ $post->title }}</h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-300 mt-4">
                    @if($post->user)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $post->user->name }}
                        </span>
                    @endif
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $post->published_at?->format('d \d\e F \d\e Y') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ number_format($post->views_count) }} visualizações
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ ARTICLE CONTENT ═══ --}}
    <section class="py-12 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-10">

                {{-- Article --}}
                <article class="flex-1 min-w-0">
                    <div class="fade-up prose prose-lg prose-gray max-w-none
                        prose-headings:font-bold prose-headings:text-gray-900
                        prose-h2:text-2xl prose-h2:mt-10 prose-h2:mb-4
                        prose-h3:text-xl prose-h3:mt-8 prose-h3:mb-3
                        prose-p:text-gray-600 prose-p:leading-relaxed
                        prose-a:text-red-600 prose-a:no-underline hover:prose-a:underline
                        prose-strong:text-gray-900
                        prose-img:rounded-xl prose-img:shadow-md
                        prose-blockquote:border-l-red-600 prose-blockquote:bg-red-50 prose-blockquote:py-1 prose-blockquote:px-6 prose-blockquote:rounded-r-lg
                        prose-ul:list-disc prose-ol:list-decimal
                    ">
                        {!! $post->content !!}
                    </div>

                    {{-- Share Buttons --}}
                    <div class="mt-10 pt-8 border-t border-gray-100 fade-up">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Compartilhar este artigo</h3>
                        <div class="flex items-center gap-3">
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 bg-green-100 hover:bg-green-600 text-green-600 hover:text-white px-4 py-2.5 rounded-lg font-medium text-sm transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                                WhatsApp
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 bg-sky-100 hover:bg-sky-600 text-sky-600 hover:text-white px-4 py-2.5 rounded-lg font-medium text-sm transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                LinkedIn
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 bg-blue-100 hover:bg-blue-600 text-blue-600 hover:text-white px-4 py-2.5 rounded-lg font-medium text-sm transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </a>
                            <button
                                onclick="navigator.clipboard.writeText(window.location.href); this.textContent = 'Copiado!';"
                                class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-700 text-gray-600 hover:text-white px-4 py-2.5 rounded-lg font-medium text-sm transition-all"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                Copiar Link
                            </button>
                        </div>
                    </div>

                    {{-- Author Box --}}
                    @if($post->user)
                        <div class="mt-8 bg-gray-50 rounded-2xl p-6 flex items-start gap-4 fade-up">
                            <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-lg">{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $post->user->name }}</h4>
                                <p class="text-gray-500 text-sm mt-1">Equipe MiFire - Especialistas em segurança contra incêndio.</p>
                            </div>
                        </div>
                    @endif
                </article>

                {{-- Sidebar --}}
                <aside class="lg:w-80 flex-shrink-0">
                    <div class="sticky top-24 space-y-6">

                        {{-- Related Posts --}}
                        @if($relatedPosts->count() > 0)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Posts Relacionados</h3>
                                <div class="space-y-4">
                                    @foreach($relatedPosts as $related)
                                        <a href="{{ route('blog.show', $related->slug) }}" class="flex items-start gap-3 group">
                                            <div class="w-20 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                                @if($related->featured_image)
                                                    <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover" loading="lazy">
                                                @else
                                                    <div class="w-full h-full bg-red-100 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1"/></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-2">{{ $related->title }}</h4>
                                                <span class="text-xs text-gray-400 mt-1 block">{{ $related->published_at?->format('d/m/Y') }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Downloads CTA --}}
                        <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-2xl p-6 text-white">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="font-bold text-lg mb-2">Downloads</h3>
                            <p class="text-red-100 text-sm mb-4">Acesse manuais, catálogos e materiais técnicos.</p>
                            <a href="{{ route('downloads.index') }}" class="inline-flex items-center gap-2 bg-white text-red-600 font-bold text-sm px-4 py-2.5 rounded-lg hover:bg-gray-100 transition-colors">
                                Ver Downloads
                            </a>
                        </div>

                        {{-- Contact CTA --}}
                        <div class="bg-gray-900 rounded-2xl p-6 text-white">
                            <h3 class="font-bold text-lg mb-2">Precisa de ajuda?</h3>
                            <p class="text-gray-400 text-sm mb-4">Nossa equipe de especialistas está pronta para atender você.</p>
                            <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-4 py-2.5 rounded-lg transition-colors">
                                Fale Conosco
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- ═══ RELATED POSTS GRID ═══ --}}
    @if($relatedPosts->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-10 fade-up">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900">Continue <span class="text-red-600">lendo</span></h2>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <article class="fade-up group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <a href="{{ route('blog.show', $related->slug) }}" class="block">
                                <div class="relative h-44 overflow-hidden">
                                    @if($related->featured_image)
                                        <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1"/></svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-5">
                                <span class="text-xs text-gray-400">{{ $related->published_at?->format('d/m/Y') }}</span>
                                <a href="{{ route('blog.show', $related->slug) }}">
                                    <h3 class="text-base font-bold text-gray-900 group-hover:text-red-600 transition-colors mt-1 line-clamp-2">{{ $related->title }}</h3>
                                </a>
                                <a href="{{ route('blog.show', $related->slug) }}" class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-3 hover:gap-2 transition-all">
                                    Ler mais <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
