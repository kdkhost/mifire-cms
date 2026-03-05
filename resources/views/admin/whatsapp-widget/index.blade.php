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
                                        <input type="file" :name="'attendants['+index+'][image]'" accept="image/*"
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
                            whatsapp: ''
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