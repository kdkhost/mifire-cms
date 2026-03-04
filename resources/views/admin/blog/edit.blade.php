@extends('admin.layout')

@section('title', 'Editar Post')

@section('content')
<div x-data="blogForm()">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Editar Post</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $blog->title }}</p>
        </div>
        <a href="{{ route('admin.blog.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $blog->title) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Título do post">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Resumo</label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Breve resumo do post...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                        @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Content --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Conteúdo <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="15"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Conteúdo completo do post...">{{ old('content', $blog->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- SEO --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">SEO</h3>
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Título para SEO" maxlength="70">
                        @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Descrição para SEO" maxlength="160">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Publish --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Publicação</h3>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                        <select name="category_id" id="category_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">Sem categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700">Publicado</label>
                        <button type="button" @click="isPublished = !isPublished"
                                :class="isPublished ? 'bg-red-600' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                            <span :class="isPublished ? 'translate-x-6' : 'translate-x-1'"
                                  class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                        </button>
                        <input type="hidden" name="is_published" :value="isPublished ? 1 : 0">
                    </div>

                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Data de Publicação</label>
                        <input type="datetime-local" name="published_at" id="published_at"
                               value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i') ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('published_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="text-xs text-gray-400">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ number_format($blog->views_count) }} visualizações
                        </span>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                            Salvar Alterações
                        </button>
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">Imagem Destaque</h3>
                    <div x-data="{ preview: '{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : '' }}' }"
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
    function blogForm() {
        return {
            isPublished: {{ old('is_published', $blog->is_published) ? 'true' : 'false' }},
        }
    }
</script>
@endpush
@endsection