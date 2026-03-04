@extends('admin.layout')

@section('title', 'Novo Produto')

@section('content')
    <div x-data="productForm()">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Novo Produto</h1>
                <p class="text-sm text-gray-500 mt-1">Adicione um novo produto ao catálogo</p>
            </div>
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="ajax-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Name --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Nome do produto">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoria <span
                                    class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Selecione...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Descriptions --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <div>
                            <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Descrição
                                Curta</label>
                            <textarea name="short_description" id="short_description" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Breve descrição do produto...">{{ old('short_description') }}</textarea>
                            @error('short_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição
                                Completa</label>
                            <textarea name="description" id="description" rows="8"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Descrição detalhada do produto...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Specifications --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Especificações</h3>
                            <button type="button" @click="addSpec()"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Adicionar
                            </button>
                        </div>
                        <div class="space-y-3">
                            <template x-for="(spec, index) in specs" :key="index">
                                <div class="flex gap-3 items-start">
                                    <div class="flex-1">
                                        <input type="text" :name="'specifications['+index+'][key]'" x-model="spec.key"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                            placeholder="Nome (ex: Peso)">
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" :name="'specifications['+index+'][value]'" x-model="spec.value"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                            placeholder="Valor (ex: 2.5kg)">
                                    </div>
                                    <button type="button" @click="specs.splice(index, 1)"
                                        class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <div x-show="specs.length === 0" class="text-center py-6 text-gray-400 text-sm">
                                Nenhuma especificação adicionada
                            </div>
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">SEO</h3>
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Título para SEO" maxlength="70">
                            @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta
                                Description</label>
                            <textarea name="meta_description" id="meta_description" rows="2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Descrição para SEO" maxlength="160">{{ old('meta_description') }}</textarea>
                            @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Publish --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Publicação</h3>

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

                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Destaque</label>
                            <button type="button" @click="isFeatured = !isFeatured"
                                :class="isFeatured ? 'bg-amber-500' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                                <span :class="isFeatured ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                            </button>
                            <input type="hidden" name="is_featured" :value="isFeatured ? 1 : 0">
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                                Criar Produto
                            </button>
                        </div>
                    </div>

                    {{-- Main Image --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">Imagem Principal</h3>
                        <div x-data="{ preview: null }" @dragover.prevent="$el.classList.add('border-red-500')"
                            @dragleave="$el.classList.remove('border-red-500')" @drop.prevent="
                                     $el.classList.remove('border-red-500');
                                     if ($event.dataTransfer.files.length) {
                                         $refs.mainImage.files = $event.dataTransfer.files;
                                         const reader = new FileReader();
                                         reader.onload = (e) => preview = e.target.result;
                                         reader.readAsDataURL($event.dataTransfer.files[0]);
                                     }
                                 ">
                            <template x-if="preview">
                                <div class="relative mb-3">
                                    <img :src="preview" class="w-full h-40 object-cover rounded-lg">
                                    <button type="button" @click="preview = null; $refs.mainImage.value = ''"
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
                                <input type="file" name="image" accept="image/*" class="hidden" x-ref="mainImage" @change="
                                               const reader = new FileReader();
                                               reader.onload = (e) => preview = e.target.result;
                                               reader.readAsDataURL($event.target.files[0]);
                                           ">
                            </label>
                        </div>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Gallery --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">Galeria</h3>
                        <div x-data="{ previews: [] }">
                            <label
                                class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-400 hover:bg-red-50/50 transition-colors">
                                <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-xs text-gray-500">Múltiplas imagens</span>
                                <input type="file" name="gallery[]" accept="image/*" multiple class="hidden" @change="
                                               previews = [];
                                               Array.from($event.target.files).forEach(file => {
                                                   const reader = new FileReader();
                                                   reader.onload = (e) => previews.push(e.target.result);
                                                   reader.readAsDataURL(file);
                                               });
                                           ">
                            </label>
                            <div class="grid grid-cols-3 gap-2 mt-3" x-show="previews.length > 0">
                                <template x-for="(src, i) in previews" :key="i">
                                    <img :src="src" class="w-full h-20 object-cover rounded-lg">
                                </template>
                            </div>
                        </div>
                        @error('gallery') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        @error('gallery.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Datasheet --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">Datasheet (PDF)</h3>
                        <label
                            class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-400 hover:bg-red-50/50 transition-colors">
                            <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-xs text-gray-500">Upload PDF</span>
                            <input type="file" name="datasheet" accept=".pdf" class="hidden">
                        </label>
                        @error('datasheet') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function productForm() {
                return {
                    isActive: {{ old('is_active', 1) ? 'true' : 'false' }},
                    isFeatured: {{ old('is_featured', 0) ? 'true' : 'false' }},
                    specs: @json(old('specifications', [['key' => '', 'value' => '']])),
                    addSpec() {
                        this.specs.push({ key: '', value: '' });
                    }
                }
            }
        </script>
    @endpush
@endsection