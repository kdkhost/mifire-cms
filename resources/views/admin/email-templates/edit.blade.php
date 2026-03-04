@extends('admin.layout')

@section('title', 'Editar Template - ' . $template->name)

@section('content')
<div x-data="templateForm()">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Editar Template</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $template->name }} <span class="font-mono text-xs">({{ $template->slug }})</span></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.email-templates.preview', $template) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Visualizar
            </a>
            <a href="{{ route('admin.email-templates.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Voltar
            </a>
        </div>
    </div>

    <form action="{{ route('admin.email-templates.update', $template) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $template->name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Assunto <span class="text-red-500">*</span></label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject', $template->subject) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Utilize variáveis Ex: Olá @{{ name }}">
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Corpo do E-mail (HTML) <span class="text-red-500">*</span></label>
                        <textarea name="body" id="body" rows="18" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('body', $template->body) }}</textarea>
                        @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Status</h3>
                    <div class="flex items-center justify-between">
                        <label class="text-sm text-gray-600">Ativo</label>
                        <button type="button" @click="isActive = !isActive"
                                :class="isActive ? 'bg-red-600' : 'bg-gray-300'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                            <span :class="isActive ? 'translate-x-6' : 'translate-x-1'"
                                  class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                        </button>
                        <input type="hidden" name="is_active" :value="isActive ? 1 : 0">
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Variáveis Disponíveis</h3>
                    <p class="text-xs text-gray-500 mb-3">Clique para copiar e cole no corpo do e-mail.</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($template->variables ?? [] as $var)
                            <button type="button" onclick="navigator.clipboard.writeText('@{{ {{ $var }} }}'); Swal.fire({toast:true,position:'top-end',icon:'success',title:'Copiado!',showConfirmButton:false,timer:1000})"
                                    class="inline-flex items-center px-2.5 py-1 rounded text-xs font-mono bg-gray-100 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors cursor-pointer">
                                @{{ {{ $var }} }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Atenção</p>
                            <p class="text-xs text-yellow-700 mt-1">Alterações no template afetarão todos os e-mails futuros. Use a visualização para conferir antes de salvar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                Salvar Template
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function templateForm() {
        return { isActive: {{ old('is_active', $template->is_active) ? 'true' : 'false' }} }
    }
</script>
@endpush
@endsection
