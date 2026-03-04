@extends('admin.layout')

@section('title', 'Nova Marca')

@section('content')
    <div x-data="brandForm()">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nova Marca</h1>
                <p class="text-sm text-gray-500 mt-1">Adicione uma nova marca parceira</p>
            </div>
            <a href="{{ route('admin.brands.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </a>
        </div>

        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="ajax-form">
            @csrf
            <div class="max-w-2xl space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="Nome da marca">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                        <input type="url" name="url" id="url" value="{{ old('url') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="https://www.marca.com.br">
                        @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Logo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Logo <span
                                class="text-red-500">*</span></label>
                        <div x-data="{ preview: null }" @dragover.prevent="$el.classList.add('border-red-500')"
                            @dragleave="$el.classList.remove('border-red-500')" @drop.prevent="
                                 $el.classList.remove('border-red-500');
                                 if ($event.dataTransfer.files.length) {
                                     $refs.logoInput.files = $event.dataTransfer.files;
                                     const reader = new FileReader();
                                     reader.onload = (e) => preview = e.target.result;
                                     reader.readAsDataURL($event.dataTransfer.files[0]);
                                 }
                             ">
                            <template x-if="preview">
                                <div class="relative mb-3 inline-block">
                                    <img :src="preview" class="h-24 object-contain rounded-lg border border-gray-200 p-2">
                                    <button type="button" @click="preview = null; $refs.logoInput.value = ''"
                                        class="absolute -top-2 -right-2 p-1 bg-red-600 text-white rounded-full hover:bg-red-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <span class="text-xs text-gray-500">Arraste ou clique para enviar o logo</span>
                                <input type="file" name="logo" accept="image/*" class="hidden" x-ref="logoInput" required
                                    @change="
                                           const reader = new FileReader();
                                           reader.onload = (e) => preview = e.target.result;
                                           reader.readAsDataURL($event.target.files[0]);
                                       ">
                            </label>
                        </div>
                        @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700">Ativa</label>
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
                        Criar Marca
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function brandForm() {
                return { isActive: {{ old('is_active', 1) ? 'true' : 'false' }} }
            }
        </script>
    @endpush
@endsection