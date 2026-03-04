@extends('admin.layout')

@section('title', 'Editar Categoria')

@section('content')
    <div x-data="categoryForm()">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar Categoria</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $category->name }}</p>
            </div>
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </a>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data"
            class="ajax-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Nome da categoria">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipo <span
                                        class="text-red-500">*</span></label>
                                <select name="type" id="type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="">Selecione...</option>
                                    <option value="product" {{ old('type', $category->type) == 'product' ? 'selected' : '' }}>
                                        Produtos</option>
                                    <option value="blog" {{ old('type', $category->type) == 'blog' ? 'selected' : '' }}>Blog
                                    </option>
                                    <option value="download" {{ old('type', $category->type) == 'download' ? 'selected' : '' }}>Downloads</option>
                                </select>
                                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Categoria
                                    Pai</label>
                                <select name="parent_id" id="parent_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="">Nenhuma (raiz)</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Descrição da categoria">{{ old('description', $category->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Status --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Publicação</h3>
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Ativa</label>
                            <button type="button" @click="isActive = !isActive"
                                :class="isActive ? 'bg-red-600' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                                <span :class="isActive ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                            </button>
                            <input type="hidden" name="is_active" :value="isActive ? 1 : 0">
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                                Salvar Alterações
                            </button>
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">Imagem</h3>
                        <div x-data="{ preview: '{{ $category->image ? asset('storage/' . $category->image) : '' }}' }"
                            @dragover.prevent="$el.classList.add('border-red-500')"
                            @dragleave="$el.classList.remove('border-red-500')" @drop.prevent="
                                 $el.classList.remove('border-red-500');
                                 if ($event.dataTransfer.files.length) {
                                     $refs.imageInput.files = $event.dataTransfer.files;
                                     const reader = new FileReader();
                                     reader.onload = (e) => preview = e.target.result;
                                     reader.readAsDataURL($event.dataTransfer.files[0]);
                                 }
                             ">
                            <template x-if="preview">
                                <div class="relative mb-3">
                                    <img :src="preview" class="w-full h-40 object-cover rounded-lg">
                                    <button type="button" @click="preview = ''; $refs.imageInput.value = ''"
                                        class="absolute top-2 right-2 p-1 bg-red-600 text-white rounded-full hover:bg-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <label
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-400 hover:bg-red-50/50 transition-colors"
                                x-show="!preview">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-500">Arraste ou clique para enviar</span>
                                <input type="file" name="image" accept="image/*" class="hidden" x-ref="imageInput" @change="
                                           const reader = new FileReader();
                                           reader.onload = (e) => preview = e.target.result;
                                           reader.readAsDataURL($event.target.files[0]);
                                       ">
                            </label>
                        </div>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function categoryForm() {
                return {
                    isActive: {{ old('is_active', $category->is_active) ? 'true' : 'false' }},
                }
            }
        </script>
    @endpush
@endsection