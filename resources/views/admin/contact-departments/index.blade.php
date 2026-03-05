@extends('admin.layout')

@section('title', 'Departamentos de Contato')

@section('content')
    <div x-data="contactDepts({{ json_encode($departments) }})">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Departamentos de Contato</h1>
                <p class="text-sm text-gray-500 mt-1">Gerencie os setores exibidos no rodapé do site (Vendas, Suporte, etc.)
                </p>
            </div>
            <button @click="addDepartment()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Departamento
            </button>
        </div>

        <form action="{{ route('admin.contact-departments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <template x-for="(dept, index) in departments" :key="index">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 relative group">
                        <button type="button" @click="removeDepartment(index)"
                            class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Imagem/Avatar --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto / Imagem do Atendente ou
                                    Loja (Para Widget Novo)</label>
                                <div class="flex items-center gap-4">
                                    <template x-if="dept.image">
                                        <img :src="'/storage/' + dept.image"
                                            class="w-16 h-16 rounded-full object-cover border-2 border-green-500 shadow-sm">
                                    </template>
                                    <template x-if="!dept.image">
                                        <div
                                            class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center border-2 border-gray-200">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    </template>
                                    <div>
                                        <input type="file" :name="'departments['+index+'][image]'" accept="image/*"
                                            class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-all">
                                        <input type="hidden" :name="'departments['+index+'][image]'" x-model="dept.image">
                                    </div>
                                </div>
                            </div>

                            {{-- Nome do Setor --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Setor (Ex: VENDAS
                                    EXTINTORES)</label>
                                <input type="text" :name="'departments['+index+'][name]'" x-model="dept.name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 uppercase">
                            </div>

                            {{-- Descrição do Setor --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subtítulo / Descrição
                                    Rápida</label>
                                <input type="text" :name="'departments['+index+'][description]'" x-model="dept.description"
                                    placeholder="Ex: Atendimento Técnico"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            {{-- Telefones --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telefones (Use / para
                                    separar)</label>
                                <input type="text" :name="'departments['+index+'][phones]'" x-model="dept.phones"
                                    placeholder="11-2450-6878 / 21-2111-4151"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            {{-- WhatsApp --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        <i class="fab fa-whatsapp text-green-500"></i>
                                    </span>
                                    <input type="text" :name="'departments['+index+'][whatsapp]'" x-model="dept.whatsapp"
                                        placeholder="11-94440-5579"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                </div>
                            </div>

                            {{-- E-mail --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail do Setor</label>
                                <input type="email" :name="'departments['+index+'][email]'" x-model="dept.email"
                                    placeholder="comercial@exemplo.com.br"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 uppercase">
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="departments.length === 0"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center text-gray-400">
                    Nenhum departamento cadastrado. Clique em "Novo Departamento" para começar.
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit"
                        class="px-8 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-all shadow-lg hover:scale-105">
                        SALVAR TODOS OS DEPARTAMENTOS
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function contactDepts(initialDepts) {
                return {
                    departments: initialDepts || [],
                    addDepartment() {
                        this.departments.push({
                            name: '',
                            description: '',
                            image: '',
                            phones: '',
                            whatsapp: '',
                            email: ''
                        });
                    },
                    removeDepartment(index) {
                        if (confirm('Deseja remover este departamento?')) {
                            this.departments.splice(index, 1);
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection