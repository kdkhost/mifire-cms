@extends('site.layout')

@section('title', 'Downloads - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', 'Baixe manuais, fichas de emergência, certificados e outros materiais técnicos da MiFire.')
@section('meta_keywords', 'downloads, manuais, fichas técnicas, certificados, catálogos, MiFire')

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="relative bg-gray-900 py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <span class="inline-block text-red-400 text-sm font-bold uppercase tracking-widest mb-3">Materiais</span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-4">Downloads</h1>
            <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>
            <p class="text-gray-400 text-lg mt-4 max-w-2xl mx-auto">Acesse manuais, fichas de emergência, certificados e outros materiais técnicos.</p>
        </div>
    </section>

    {{-- ═══ DOWNLOADS CONTENT ═══ --}}
    <section class="py-16 lg:py-24 bg-white" x-data="{ activeTab: '{{ $categories->first()?->slug ?? '' }}' }">
        <div class="max-w-7xl mx-auto px-4">

            @if($categories->count() > 0)
                {{-- Category Tabs --}}
                <div class="flex flex-wrap items-center gap-2 mb-10 border-b border-gray-200 pb-4 fade-up">
                    @foreach($categories as $category)
                        <button
                            @click="activeTab = '{{ $category->slug }}'"
                            :class="activeTab === '{{ $category->slug }}'
                                ? 'bg-red-600 text-white shadow-md'
                                : 'bg-gray-100 text-gray-600 hover:bg-red-50 hover:text-red-600'"
                            class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200"
                        >
                            <span class="flex items-center gap-2">
                                @switch($category->name)
                                    @case('Manuais')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        @break
                                    @case('Ficha de Emergência')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        @break
                                    @case('Certificados')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                        @break
                                    @default
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                @endswitch
                                {{ $category->name }}
                                <span class="bg-white/20 text-xs px-1.5 py-0.5 rounded" :class="activeTab === '{{ $category->slug }}' ? 'bg-white/20' : 'bg-gray-200'">{{ $category->downloads->count() }}</span>
                            </span>
                        </button>
                    @endforeach
                </div>

                {{-- Downloads by Category --}}
                @foreach($categories as $category)
                    <div
                        x-show="activeTab === '{{ $category->slug }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-cloak
                    >
                        @if($category->downloads->count() > 0)
                            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($category->downloads as $download)
                                    <div class="fade-up bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg hover:border-red-100 transition-all duration-300 group">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-base font-bold text-gray-900 group-hover:text-red-600 transition-colors">{{ $download->title }}</h3>
                                                @if($download->description)
                                                    <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $download->description }}</p>
                                                @endif
                                                <div class="flex items-center gap-3 mt-3">
                                                    @if($download->file_size)
                                                        <span class="text-xs text-gray-400 flex items-center gap-1">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                            {{ $download->file_size }}
                                                        </span>
                                                    @endif
                                                    <span class="text-xs text-gray-400 flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3"/></svg>
                                                        {{ number_format($download->download_count) }} downloads
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('downloads.download', $download->id) }}"
                                           class="mt-4 w-full inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm px-4 py-2.5 rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            Baixar Arquivo
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <p class="text-gray-500">Nenhum arquivo disponível nesta categoria.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <p class="text-gray-500 text-lg">Nenhum download disponível no momento.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 text-center fade-up">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Precisa de outro material?</h2>
            <p class="text-gray-500 mb-6">Entre em contato conosco e solicite o material que você precisa.</p>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                Fale Conosco
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

@endsection
