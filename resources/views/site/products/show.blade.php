@extends('site.layout')

@section('title', ($product->meta_title ?: $product->name) . ' - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', $product->meta_description ?: ($product->short_description ?: Str::limit(strip_tags($product->description), 160)))
@section('og_title', $product->name . ' - MiFire')
@section('og_description', $product->short_description ?? '')
@section('og_image', $product->image ? asset('storage/' . $product->image) : '')

@section('content')

    {{-- ═══ BREADCRUMB BAR ═══ --}}
    <section class="bg-gray-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <nav aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-red-600 transition-colors">Home</a></li>
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-red-600 transition-colors">Produtos</a></li>
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li><a href="{{ route('products.category', $category->slug) }}" class="hover:text-red-600 transition-colors">{{ $category->name }}</a></li>
                    <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                    <li class="text-gray-900 font-medium">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </section>

    {{-- ═══ PRODUCT DETAIL ═══ --}}
    <section class="py-12 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">

                {{-- Image Gallery --}}
                <div
                    x-data="{
                        mainImage: '{{ $product->image ? asset('storage/' . $product->image) : '' }}',
                        gallery: {{ json_encode($product->gallery ?? []) }},
                        zoomed: false,
                        zoomX: 50,
                        zoomY: 50
                    }"
                    class="fade-up"
                >
                    {{-- Main Image --}}
                    <div
                        class="relative rounded-2xl overflow-hidden bg-gray-100 cursor-zoom-in group"
                        @click="zoomed = true"
                        @mousemove="zoomX = ($event.offsetX / $el.offsetWidth) * 100; zoomY = ($event.offsetY / $el.offsetHeight) * 100"
                    >
                        <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-80 md:h-[480px] object-contain p-4" loading="eager">
                        @if($product->is_featured)
                            <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full">Destaque</span>
                        @endif
                    </div>

                    {{-- Thumbnails --}}
                    @if($product->gallery && count($product->gallery) > 0)
                        <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                            {{-- Main image thumb --}}
                            @if($product->image)
                                <button
                                    @click="mainImage = '{{ asset('storage/' . $product->image) }}'"
                                    :class="mainImage === '{{ asset('storage/' . $product->image) }}' ? 'ring-2 ring-red-600' : 'ring-1 ring-gray-200 hover:ring-red-300'"
                                    class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gray-100 transition-all"
                                >
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                                </button>
                            @endif

                            @foreach($product->gallery as $image)
                                <button
                                    @click="mainImage = '{{ asset('storage/' . $image) }}'"
                                    :class="mainImage === '{{ asset('storage/' . $image) }}' ? 'ring-2 ring-red-600' : 'ring-1 ring-gray-200 hover:ring-red-300'"
                                    class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gray-100 transition-all"
                                >
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Lightbox --}}
                    <div
                        x-show="zoomed"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        x-cloak
                        @click="zoomed = false"
                        @keydown.escape.window="zoomed = false"
                        class="fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-4 cursor-zoom-out"
                    >
                        <button @click.stop="zoomed = false" class="absolute top-4 right-4 text-white hover:text-red-400 transition-colors z-10">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        <img :src="mainImage" alt="{{ $product->name }}" class="max-w-full max-h-[90vh] object-contain rounded-lg">
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="fade-up">
                    @if($category)
                        <a href="{{ route('products.category', $category->slug) }}" class="inline-flex items-center gap-1 text-red-600 text-sm font-semibold mb-3 hover:text-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            {{ $category->name }}
                        </a>
                    @endif

                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-900 mb-4">{{ $product->name }}</h1>

                    @if($product->short_description)
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">{{ $product->short_description }}</p>
                    @endif

                    {{-- Description --}}
                    @if($product->description)
                        <div class="prose prose-gray prose-p:text-gray-600 prose-a:text-red-600 max-w-none mb-8">
                            {!! $product->description !!}
                        </div>
                    @endif

                    {{-- Specifications --}}
                    @if($product->specifications && count($product->specifications) > 0)
                        <div class="mb-8">
                            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Especificações Técnicas
                            </h2>
                            <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                                <table class="w-full text-sm">
                                    <tbody>
                                        @foreach($product->specifications as $key => $value)
                                            <tr class="border-b border-gray-100 last:border-b-0">
                                                <td class="px-5 py-3.5 font-semibold text-gray-900 bg-gray-100/50 w-1/3">{{ $key }}</td>
                                                <td class="px-5 py-3.5 text-gray-600">{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-3 mb-8">
                        <a href="{{ route('contact.index') }}?product={{ urlencode($product->name) }}" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-7 py-3.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Solicitar Orçamento
                        </a>

                        @if($product->datasheet_url)
                            <a href="{{ asset('storage/' . $product->datasheet_url) }}" target="_blank" class="inline-flex items-center justify-center gap-2 border-2 border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white font-bold px-7 py-3.5 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Baixar Datasheet
                            </a>
                        @endif

                        @if($settings->get('whatsapp'))
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->get('whatsapp')) }}?text={{ urlencode('Olá! Tenho interesse no produto: ' . $product->name . '. Poderia me enviar mais informações?') }}"
                               target="_blank"
                               class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold px-7 py-3.5 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                                WhatsApp
                            </a>
                        @endif
                    </div>

                    {{-- Share --}}
                    <div class="border-t border-gray-100 pt-6">
                        <span class="text-sm font-semibold text-gray-500 mr-3">Compartilhar:</span>
                        <div class="inline-flex items-center gap-2">
                            <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . url()->current()) }}" target="_blank" class="w-9 h-9 bg-green-100 hover:bg-green-600 text-green-600 hover:text-white rounded-lg flex items-center justify-center transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="w-9 h-9 bg-blue-100 hover:bg-blue-600 text-blue-600 hover:text-white rounded-lg flex items-center justify-center transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank" class="w-9 h-9 bg-sky-100 hover:bg-sky-600 text-sky-600 hover:text-white rounded-lg flex items-center justify-center transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ RELATED PRODUCTS ═══ --}}
    @if($relatedProducts->count() > 0)
        <section class="py-16 lg:py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-10 fade-up">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900">Produtos <span class="text-red-600">Relacionados</span></h2>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', [$category->slug, $related->slug]) }}"
                           class="fade-up group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative h-44 overflow-hidden bg-gray-100">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-2">{{ $related->name }}</h3>
                                <span class="inline-flex items-center gap-1 text-red-600 font-semibold text-xs mt-2 group-hover:gap-1.5 transition-all">
                                    Ver produto <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ CTA ═══ --}}
    <section class="py-16 bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 text-center fade-up">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Interessado neste produto?</h2>
            <p class="text-gray-400 mb-6">Solicite um orçamento personalizado ou fale direto com nosso especialista.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('contact.index') }}?product={{ urlencode($product->name) }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg transition-all duration-200">
                    Solicitar Orçamento
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

@endsection
