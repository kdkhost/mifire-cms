@extends('admin.layout')

@section('title', 'Novo Item de Menu')

@section('content')
<div x-data="menuForm()">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Novo Item de Menu</h1>
            <p class="text-sm text-gray-500 mt-1">Adicione um item à navegação do site</p>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.menus.store') }}" method="POST">
        @csrf
        <div class="max-w-2xl space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Texto do link">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tipo de link --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Link</label>
                    <div class="flex gap-4 mb-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="link_type" value="url" x-model="linkType" class="text-red-600 focus:ring-red-500">
                            <span class="text-sm text-gray-700">URL personalizada</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="link_type" value="page" x-model="linkType" class="text-red-600 focus:ring-red-500">
                            <span class="text-sm text-gray-700">Página interna</span>
                        </label>
                    </div>

                    <div x-show="linkType === 'url'">
                        <input type="url" name="url" value="{{ old('url') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="https://exemplo.com ou /rota">
                        @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div x-show="linkType === 'page'">
                        <select name="page_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">Selecione uma página</option>
                            @foreach($pages as $page)
                                <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                            @endforeach
                        </select>
                        @error('page_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Localização <span class="text-red-500">*</span></label>
                        <select name="location" id="location" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="header" {{ old('location') === 'header' ? 'selected' : '' }}>Header</option>
                            <option value="footer" {{ old('location') === 'footer' ? 'selected' : '' }}>Footer</option>
                        </select>
                        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Menu Pai</label>
                        <select name="parent_id" id="parent_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">Nenhum (raiz)</option>
                            @foreach($parentMenus as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                            @endforeach
                        </select>
                        @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="target" class="block text-sm font-medium text-gray-700 mb-1">Abrir em</label>
                        <select name="target" id="target"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="_self" {{ old('target') === '_self' ? 'selected' : '' }}>Mesma aba</option>
                            <option value="_blank" {{ old('target') === '_blank' ? 'selected' : '' }}>Nova aba</option>
                        </select>
                        @error('target') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Ícone (classe CSS)</label>
                        <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Ex: fas fa-home">
                        @error('icon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="text-sm font-medium text-gray-700">Ativo</label>
                    <button type="button" @click="isActive = !isActive"
                            :class="isActive ? 'bg-red-600' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                        <span :class="isActive ? 'translate-x-6' : 'translate-x-1'"
                              class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                    </button>
                    <input type="hidden" name="is_active" :value="isActive ? 1 : 0">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                    Criar Item
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function menuForm() {
        return {
            isActive: {{ old('is_active', 1) ? 'true' : 'false' }},
            linkType: '{{ old('link_type', old('page_id') ? 'page' : 'url') }}'
        }
    }
</script>
@endpush
@endsection
