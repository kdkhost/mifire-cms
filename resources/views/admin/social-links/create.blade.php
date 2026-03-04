@extends('admin.layout')

@section('title', 'Nova Rede Social')

@section('content')
    <div x-data="socialForm()">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nova Rede Social</h1>
                <p class="text-sm text-gray-500 mt-1">Adicione um link de rede social</p>
            </div>
            <a href="{{ route('admin.social-links.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </a>
        </div>

        <form action="{{ route('admin.social-links.store') }}" method="POST" enctype="multipart/form-data"
            class="ajax-form">
            @csrf
            <div class="max-w-2xl space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div>
                        <label for="platform" class="block text-sm font-medium text-gray-700 mb-1">Plataforma <span
                                class="text-red-500">*</span></label>
                        <select name="platform" id="platform" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">Selecione</option>
                            @foreach(['facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 'tiktok', 'pinterest', 'whatsapp', 'telegram', 'github', 'outro'] as $p)
                                <option value="{{ $p }}" {{ old('platform') === $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                            @endforeach
                        </select>
                        @error('platform') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL <span
                                class="text-red-500">*</span></label>
                        <input type="url" name="url" id="url" value="{{ old('url') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="https://www.instagram.com/seuusuario">
                        @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ uploadType: 'class' }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Ícone</label>
                        <div class="flex gap-4 mb-4">
                            <label class="inline-flex items-center">
                                <input type="radio" x-model="uploadType" value="class"
                                    class="text-red-600 focus:ring-red-500">
                                <span class="ml-2 text-sm text-gray-600">Classe CSS</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" x-model="uploadType" value="file"
                                    class="text-red-600 focus:ring-red-500">
                                <span class="ml-2 text-sm text-gray-600">Upload de Arquivo</span>
                            </label>
                        </div>

                        <div x-show="uploadType === 'class'">
                            <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Classe do Ícone</label>
                            <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Ex: fab fa-instagram">
                            <p class="text-xs text-gray-400 mt-1">Classe CSS do ícone (Font Awesome, etc.)</p>
                        </div>

                        <div x-show="uploadType === 'file'" x-cloak>
                            <label for="icon_file" class="block text-sm font-medium text-gray-700 mb-1">Arquivo do
                                Ícone</label>
                            <input type="file" name="icon_file" id="icon_file" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <p class="text-xs text-gray-400 mt-1">Formatos aceitos: SVG, PNG, JPG (Máx. 1MB)</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700">Ativo</label>
                        <button type="button" @click="isActive = !isActive" :class="isActive ? 'bg-red-600' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                            <span :class="isActive ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                        </button>
                        <input type="hidden" name="is_active" :value="isActive ? 1 : 0">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                        Criar Rede Social
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function socialForm() {
                return { isActive: {{ old('is_active', 1) ? 'true' : 'false' }} }
            }
        </script>
    @endpush
@endsection