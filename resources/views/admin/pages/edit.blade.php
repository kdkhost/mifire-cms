@extends('admin.layout')

@section('title', 'Editar Página')

@section('content')
<div x-data="pageForm()">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Editar Página</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $page->title }}</p>
        </div>
        <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Title & Slug --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" required
                               x-model="title" @input="generateSlug()"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Título da página">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-400 mr-1">/</span>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}"
                                   x-model="slug"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono"
                                   placeholder="url-da-pagina">
                        </div>
                        @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Content --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Conteúdo</label>
                    <textarea name="content" id="content" rows="12"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Conteúdo da página...">{{ old('content', $page->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- SEO --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">SEO</h3>
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Título para SEO" maxlength="70">
                        @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Descrição para SEO" maxlength="160">{{ old('meta_description', $page->meta_description) }}</textarea>
                        @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Separadas por vírgula">
                        @error('meta_keywords') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Publish --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Publicação</h3>

                    <div>
                        <label for="template" class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                        <select name="template" id="template"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="default" {{ old('template', $page->template) == 'default' ? 'selected' : '' }}>Padrão</option>
                            <option value="full-width" {{ old('template', $page->template) == 'full-width' ? 'selected' : '' }}>Largura Total</option>
                            <option value="sidebar" {{ old('template', $page->template) == 'sidebar' ? 'selected' : '' }}>Com Sidebar</option>
                            <option value="landing" {{ old('template', $page->template) == 'landing' ? 'selected' : '' }}>Landing Page</option>
                        </select>
                        @error('template') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="is_active" class="text-sm font-medium text-gray-700">Ativa</label>
                        <button type="button" @click="isActive = !isActive"
                                :class="isActive ? 'bg-red-600' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                            <span :class="isActive ? 'translate-x-6' : 'translate-x-1'"
                                  class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                        </button>
                        <input type="hidden" name="is_active" :value="isActive ? 1 : 0">
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex gap-3">
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                            Salvar Alterações
                        </button>
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">Imagem Destaque</h3>
                    <div x-data="{ preview: '{{ $page->featured_image ? asset('storage/' . $page->featured_image) : '' }}' }"
                         @dragover.prevent="$el.classList.add('border-red-500')"
                         @dragleave="$el.classList.remove('border-red-500')"
                         @drop.prevent="
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
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-400 hover:bg-red-50/50 transition-colors"
                               x-show="!preview">
                            <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs text-gray-500">Arraste ou clique para enviar</span>
                            <input type="file" name="featured_image" accept="image/*" class="hidden" x-ref="imageInput"
                                   @change="
                                       const reader = new FileReader();
                                       reader.onload = (e) => preview = e.target.result;
                                       reader.readAsDataURL($event.target.files[0]);
                                   ">
                        </label>
                    </div>
                    @error('featured_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function pageForm() {
        return {
            title: @json(old('title', $page->title)),
            slug: @json(old('slug', $page->slug)),
            isActive: {{ old('is_active', $page->is_active) ? 'true' : 'false' }},
            originalSlug: @json($page->slug),
            previousSlug: @json($page->slug),
            generateSlug() {
                // Only auto-generate if slug was auto-generated before
            }
        }
    }
</script>
@endpush
@endsection
