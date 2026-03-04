@extends('site.layout')

@section('title', 'Contato - ' . ($settings->get('site_name', 'MiFire')))
@section('meta_description', 'Entre em contato com a MiFire. Solicite orçamentos, tire dúvidas ou agende uma visita técnica.')
@section('meta_keywords', 'contato, orçamento, MiFire, telefone, email, segurança contra incêndio')

@section('content')

    {{-- ═══ HERO ═══ --}}
    <section class="relative bg-gray-900 py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <span class="inline-block text-red-400 text-sm font-bold uppercase tracking-widest mb-3">Contato</span>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-4">Fale Conosco</h1>
            <div class="w-20 h-1 bg-red-600 mx-auto rounded-full"></div>
            <p class="text-gray-400 text-lg mt-4 max-w-2xl mx-auto">Estamos prontos para atender você. Envie sua mensagem ou entre em contato pelos nossos canais.</p>
        </div>
    </section>

    {{-- ═══ CONTACT CONTENT ═══ --}}
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-10 bg-green-50 border border-green-200 rounded-2xl p-6 fade-up" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-green-900">Mensagem enviada com sucesso!</h3>
                            <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-400 hover:text-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="grid lg:grid-cols-5 gap-10 lg:gap-16">

                {{-- Contact Form --}}
                <div class="lg:col-span-3 fade-up">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Envie sua mensagem</h2>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid sm:grid-cols-2 gap-5">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nome completo <span class="text-red-600">*</span></label>
                                <input
                                    type="text" id="name" name="name" value="{{ old('name') }}" required
                                    placeholder="Seu nome completo"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all text-sm outline-none @error('name') border-red-500 @enderror"
                                >
                                @error('name')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">E-mail <span class="text-red-600">*</span></label>
                                <input
                                    type="email" id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="seu@email.com"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all text-sm outline-none @error('email') border-red-500 @enderror"
                                >
                                @error('email')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-5">
                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1.5">Telefone</label>
                                <input
                                    type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="(00) 00000-0000"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all text-sm outline-none @error('phone') border-red-500 @enderror"
                                >
                                @error('phone')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Company --}}
                            <div>
                                <label for="company" class="block text-sm font-semibold text-gray-700 mb-1.5">Empresa</label>
                                <input
                                    type="text" id="company" name="company" value="{{ old('company') }}"
                                    placeholder="Nome da empresa"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all text-sm outline-none @error('company') border-red-500 @enderror"
                                >
                                @error('company')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1.5">Assunto <span class="text-red-600">*</span></label>
                            <input
                                type="text" id="subject" name="subject" value="{{ old('subject', request('product') ? 'Orçamento: ' . request('product') : '') }}" required
                                placeholder="Assunto da mensagem"
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all text-sm outline-none @error('subject') border-red-500 @enderror"
                            >
                            @error('subject')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-1.5">Mensagem <span class="text-red-600">*</span></label>
                            <textarea
                                id="message" name="message" rows="5" required
                                placeholder="Descreva como podemos ajudá-lo..."
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all text-sm outline-none resize-y @error('message') border-red-500 @enderror"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md w-full sm:w-auto justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Enviar Mensagem
                        </button>
                    </form>
                </div>

                {{-- Contact Info --}}
                <div class="lg:col-span-2 space-y-6 fade-up">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informações de contato</h2>

                    {{-- Addresses --}}
                    @foreach($addresses as $address)
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-sm">{{ $address->label }}</h3>
                                    <p class="text-gray-500 text-sm mt-1 leading-relaxed">
                                        {{ $address->address }}
                                        @if($address->complement)<br>{{ $address->complement }}@endif
                                        <br>{{ $address->city }} - {{ $address->state }}
                                        @if($address->zip_code)<br>CEP: {{ $address->zip_code }}@endif
                                    </p>
                                    @if($address->phone)
                                        <a href="tel:{{ $address->phone }}" class="text-red-600 text-sm font-medium mt-2 inline-block hover:text-red-700">{{ $address->phone }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Phone & Email --}}
                    <div class="space-y-3">
                        @if($settings->get('phone'))
                            <a href="tel:{{ $settings->get('phone') }}" class="flex items-center gap-3 bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-red-200 hover:bg-red-50 transition-all group">
                                <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium">Telefone</span>
                                    <p class="text-gray-900 font-semibold text-sm">{{ $settings->get('phone') }}</p>
                                </div>
                            </a>
                        @endif

                        @if($settings->get('email'))
                            <a href="mailto:{{ $settings->get('email') }}" class="flex items-center gap-3 bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-red-200 hover:bg-red-50 transition-all group">
                                <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium">E-mail</span>
                                    <p class="text-gray-900 font-semibold text-sm">{{ $settings->get('email') }}</p>
                                </div>
                            </a>
                        @endif

                        @if($settings->get('whatsapp'))
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->get('whatsapp')) }}?text={{ urlencode('Olá! Gostaria de mais informações.') }}" target="_blank" class="flex items-center gap-3 bg-green-50 rounded-xl p-4 border border-green-100 hover:border-green-200 hover:bg-green-100 transition-all group">
                                <div class="w-10 h-10 bg-green-500 text-white rounded-xl flex items-center justify-center group-hover:bg-green-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 font-medium">WhatsApp</span>
                                    <p class="text-gray-900 font-semibold text-sm">{{ $settings->get('whatsapp') }}</p>
                                </div>
                            </a>
                        @endif
                    </div>

                    {{-- Map Placeholder --}}
                    <div class="bg-gray-100 rounded-2xl overflow-hidden h-64 border border-gray-200">
                        @if($settings->get('google_maps_embed'))
                            <iframe src="{{ $settings->get('google_maps_embed') }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded-2xl"></iframe>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <p class="text-sm">Mapa em breve</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
