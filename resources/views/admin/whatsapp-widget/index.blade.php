@extends('admin.layout')

@section('title', 'Atendimento Widget')

@section('content')
    <div x-data="whatsappWidgetConfig({{ json_encode($attendants) }})">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Configurações do Widget de Atendimento</h1>
                <p class="text-sm text-gray-500 mt-1">Configure o Balão Inteligente de WhatsApp que flutua no site (Chatbox
                    V2).</p>
            </div>
            <button @click="addAttendant()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Atendente
            </button>
        </div>

        <form action="{{ route('admin.whatsapp-widget.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- CABEÇALHO DO WIDGET --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Cabeçalho do Chatbox</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título / Mensagem de Boas Vindas</label>
                    <input type="text" name="title" value="{{ $title }}" required
                        placeholder="Ex: Olá! Como podemos te ajudar?"
                        class="w-full px-4 py-2 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-2">Esta é a frase principal que aparece no topo da janela de
                        conversas.</p>
                </div>
            </div>

            {{-- APARÊNCIA DO WIDGET --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8" x-data="{
                        bgColor: '{{ $widgetBgColor }}',
                        textColor: '{{ $widgetTextColor }}'
                    }">
                <h2 class="text-lg font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-palette text-red-500 text-base"></i>
                    Aparência do Chatbox
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                    {{-- Cor de Fundo --}}
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Cor de Fundo
                            Principal</label>
                        <div class="flex flex-col gap-2">
                            <div class="relative w-full h-14 rounded-lg overflow-hidden border-2 border-white shadow-md cursor-pointer"
                                :style="'background-color:' + bgColor" title="Clique para abrir o seletor de cor">
                                <input type="color" name="widget_bg_color" x-model="bgColor"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="absolute bottom-1 right-1.5 bg-black/25 text-white text-[10px] font-mono px-1.5 py-0.5 rounded"
                                    x-text="bgColor"></div>
                            </div>
                            <div class="flex items-center gap-1.5 bg-white border border-gray-200 rounded-lg px-2 py-1">
                                <span class="w-4 h-4 rounded-full border border-gray-200 shrink-0"
                                    :style="'background-color:' + bgColor"></span>
                                <input type="text" x-model="bgColor" maxlength="7"
                                    class="flex-1 text-sm font-mono text-gray-700 bg-transparent border-0 p-0 focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-2">Cor do topo do chatbox e do botão flutuante.</p>
                    </div>

                    {{-- Cor do Ícone --}}
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Cor do Texto
                            / Ícone</label>
                        <div class="flex flex-col gap-2">
                            <div class="relative w-full h-14 rounded-lg overflow-hidden border-2 border-white shadow-md cursor-pointer"
                                :style="'background-color:' + textColor" title="Clique para abrir o seletor de cor">
                                <input type="color" name="widget_text_color" x-model="textColor"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="absolute bottom-1 right-1.5 bg-black/25 text-white text-[10px] font-mono px-1.5 py-0.5 rounded"
                                    x-text="textColor"></div>
                            </div>
                            <div class="flex items-center gap-1.5 bg-white border border-gray-200 rounded-lg px-2 py-1">
                                <span class="w-4 h-4 rounded-full border border-gray-200 shrink-0"
                                    :style="'background-color:' + textColor"></span>
                                <input type="text" x-model="textColor" maxlength="7"
                                    class="flex-1 text-sm font-mono text-gray-700 bg-transparent border-0 p-0 focus:outline-none focus:ring-0">
                            </div>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-2">Cor visível no ícone e texto (geralmente branco).</p>
                    </div>

                    {{-- Posição --}}
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Posição na
                            Tela</label>
                        <div class="grid grid-cols-2 gap-2 mt-1">
                            <label class="relative">
                                <input type="radio" name="widget_position" value="bottom-right" class="peer sr-only" {{ $widgetPosition === 'bottom-right' ? 'checked' : '' }}>
                                <div
                                    class="flex flex-col items-center justify-center gap-1.5 border-2 border-gray-200 rounded-lg p-2.5 cursor-pointer text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all hover:border-gray-300">
                                    <div class="w-8 h-6 bg-gray-200 rounded relative peer-checked:bg-red-100">
                                        <span
                                            class="absolute bottom-0.5 right-0.5 w-2 h-2 rounded-full bg-gray-400 peer-checked:bg-red-500"></span>
                                    </div>
                                    <span class="text-[11px] font-medium text-gray-600">Direito</span>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="widget_position" value="bottom-left" class="peer sr-only" {{ $widgetPosition === 'bottom-left' ? 'checked' : '' }}>
                                <div
                                    class="flex flex-col items-center justify-center gap-1.5 border-2 border-gray-200 rounded-lg p-2.5 cursor-pointer text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all hover:border-gray-300">
                                    <div class="w-8 h-6 bg-gray-200 rounded relative">
                                        <span class="absolute bottom-0.5 left-0.5 w-2 h-2 rounded-full bg-gray-400"></span>
                                    </div>
                                    <span class="text-[11px] font-medium text-gray-600">Esquerdo</span>
                                </div>
                            </label>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-3">Canto onde o botão ficará flutuando no site.</p>
                    </div>

                    {{-- Animação --}}
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Animação do
                            Ícone</label>
                        <div class="space-y-2 mt-1">
                            @foreach(['pulse' => ['Batimento (Pulse)', 'fas fa-circle-dot'], 'bounce' => ['Pulo (Bounce)', 'fas fa-arrow-up'], 'none' => ['Estático (Nenhuma)', 'fas fa-minus']] as $val => [$label, $icon])
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="radio" name="widget_animation" value="{{ $val }}" {{ $widgetAnimation === $val ? 'checked' : '' }} class="accent-red-600 w-4 h-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center group-has-[:checked]:bg-red-100 transition">
                                            <i
                                                class="{{ $icon }} text-[11px] text-gray-500 group-has-[:checked]:text-red-500"></i>
                                        </div>
                                        <span class="text-sm text-gray-700">{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-gray-400 mt-3">Efeito de movimentação do botão flutuante.</p>
                    </div>
                </div>
            </div>

            {{-- LISTA DE CONTATOS / ATENDENTES --}}
            <div class="space-y-4">
                <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2">Contatos Disponíveis no Chat</h2>

                <template x-for="(attendant, index) in attendants" :key="index">
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 relative group transform transition-all duration-200 hover:-translate-y-1 hover:border-red-200">
                        <button type="button" @click="removeAttendant(index)"
                            class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start pt-2">

                            {{-- Imagem/Avatar --}}
                            <div class="lg:col-span-3 border-b border-gray-100 pb-4 mb-2">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Foto / Avatar do
                                    Atendente</label>
                                <div class="flex items-center gap-5">
                                    <template x-if="attendant.image">
                                        <img :src="'/storage/' + attendant.image"
                                            class="w-20 h-20 rounded-full object-cover border-4 border-green-50 shadow-md">
                                    </template>
                                    <template x-if="!attendant.image">
                                        <div
                                            class="w-20 h-20 rounded-full bg-gray-50 flex items-center justify-center border border-dashed border-gray-300">
                                            <i class="fas fa-user-circle text-3xl text-gray-300"></i>
                                        </div>
                                    </template>
                                    <div class="flex-1">
                                        <input type="file" :name="'attendants['+index+'][image_upload]'" accept="image/*"
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-all cursor-pointer border border-gray-200 rounded-lg p-1">
                                        <input type="hidden" :name="'attendants['+index+'][image]'"
                                            x-model="attendant.image">
                                        <p class="text-xs text-gray-400 mt-2">Formatos recomendados: JPG ou PNG quadrado
                                            (Ex: 150x150px).</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Nome --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                                <input type="text" :name="'attendants['+index+'][name]'" x-model="attendant.name" required
                                    placeholder="Ex: João Silva"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            {{-- Cargo/Função --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cargo / Setor</label>
                                <input type="text" :name="'attendants['+index+'][role]'" x-model="attendant.role"
                                    placeholder="Ex: Suporte Técnico"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            {{-- WhatsApp --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Número do WhatsApp (Com
                                    DDD)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        <i class="fab fa-whatsapp text-green-500"></i>
                                    </span>
                                    <input type="text" :name="'attendants['+index+'][whatsapp]'"
                                        x-model="attendant.whatsapp" required placeholder="11912345678"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                </div>
                            </div>

                            {{-- Mensagem Pré-definida --}}
                            <div class="lg:col-span-3 pb-2 pt-2 border-t border-gray-50 border-dashed">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mensagem Inicial Padrão</label>
                                <input type="text" :name="'attendants['+index+'][message]'" x-model="attendant.message"
                                    placeholder="Ex: Olá Comercial! Gostaria de mais informações."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <p class="text-[11px] text-gray-400 mt-1">Texto que já virá digitado pro cliente enviar
                                    quando ele clicar neste contato. Deixe em branco para nenhuma mensagem.</p>
                            </div>

                        </div>
                    </div>
                </template>

                <div x-show="attendants.length === 0"
                    class="bg-white rounded-xl border-2 border-dashed border-gray-300 p-12 text-center flex flex-col items-center justify-center">
                    <i class="fab fa-whatsapp text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">Nenhum Atendente Configurado</h3>
                    <p class="mt-1 text-sm text-gray-500">Clique no botão "Novo Atendente" lá em cima para adicionar
                        contatos ao seu Widget.</p>
                </div>

                {{-- BOTOES DE ACAO --}}
                <div class="flex justify-end pt-8 pb-12 border-t border-gray-200 mt-8">
                    <button type="submit"
                        class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-1 flex items-center gap-2">
                        <i class="fas fa-save"></i> SALVAR CONFIGURAÇÕES DO WIDGET
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function whatsappWidgetConfig(initialData) {
                return {
                    attendants: initialData || [],
                    addAttendant() {
                        this.attendants.push({
                            name: '',
                            role: '',
                            image: '',
                            whatsapp: '',
                            message: ''
                        });
                        // Scroll pra baixo
                        setTimeout(() => {
                            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                        }, 100);
                    },
                    removeAttendant(index) {
                        Swal.fire({
                            title: 'Remover atendente?',
                            text: "Este contato sairá do Widget do site.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#9ca3af',
                            confirmButtonText: 'Sim, remover!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.attendants.splice(index, 1);
                            }
                        });
                    }
                }
            }
        </script>
    @endpush
@endsection