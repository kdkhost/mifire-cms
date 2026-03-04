@extends('site.layout')

@section('title', $page->meta_title ?: $page->title . ' - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', $page->meta_description ?: Str::limit(strip_tags($page->content), 160))
@section('meta_keywords', $page->meta_keywords ?? '')

@section('content')

    {{-- ═══ PAGE HERO ═══ --}}
    <section class="relative bg-gray-900 py-20 lg:py-28 overflow-hidden">
        {{-- Background pattern --}}
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
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-4">{{ $page->title }}</h1>
            <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>

            {{-- Breadcrumb --}}
            <nav class="mt-6" aria-label="Breadcrumb">
                <ol class="flex items-center justify-center gap-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li class="text-white font-medium">{{ $page->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    {{-- ═══ PAGE CONTENT ═══ --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4">

            {{-- Featured Image --}}
            @if($page->featured_image)
                <div class="mb-10 fade-up">
                    <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" class="w-full rounded-2xl shadow-lg object-cover max-h-[500px]" loading="lazy">
                </div>
            @endif

            {{-- Content --}}
            <div class="fade-up prose prose-lg prose-gray max-w-none
                prose-headings:font-bold prose-headings:text-gray-900
                prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-4
                prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-3
                prose-p:text-gray-600 prose-p:leading-relaxed
                prose-a:text-red-600 prose-a:no-underline hover:prose-a:underline
                prose-strong:text-gray-900
                prose-img:rounded-xl prose-img:shadow-md
                prose-blockquote:border-l-red-600 prose-blockquote:bg-red-50 prose-blockquote:py-1 prose-blockquote:px-6 prose-blockquote:rounded-r-lg
                prose-ul:list-disc prose-ol:list-decimal
                prose-table:border prose-table:border-gray-200 prose-th:bg-gray-50 prose-th:py-3 prose-th:px-4 prose-td:py-3 prose-td:px-4
            ">
                {!! $page->content !!}
            </div>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 text-center fade-up">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Ficou com alguma dúvida?</h2>
            <p class="text-gray-500 mb-6">Nossa equipe está pronta para ajudá-lo. Entre em contato conosco!</p>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                Fale Conosco
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

@endsection
