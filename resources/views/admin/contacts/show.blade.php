@extends('admin.layout')

@section('title', 'Contato - ' . $contact->name)

@section('content')
<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mensagem de Contato</h1>
            <p class="text-sm text-gray-500 mt-1">Recebida em {{ $contact->created_at->format('d/m/Y \à\s H:i') }}</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Voltar
        </a>
    </div>

    <div class="max-w-3xl space-y-6">
        {{-- Detalhes do Contato --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold text-lg">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $contact->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $contact->email }}</p>
                    </div>
                </div>
                @if($contact->replied_at)
                    <span class="inline-flex items-center gap-1 text-xs text-blue-700 bg-blue-100 px-2.5 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                        Respondido em {{ $contact->replied_at->format('d/m/Y H:i') }}
                    </span>
                @elseif($contact->is_read)
                    <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">Lido</span>
                @else
                    <span class="inline-flex items-center gap-1 text-xs text-red-700 bg-red-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Novo
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                @if($contact->phone)
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider">Telefone</span>
                        <p class="text-sm text-gray-900 mt-1">{{ $contact->phone }}</p>
                    </div>
                @endif
                @if($contact->company)
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider">Empresa</span>
                        <p class="text-sm text-gray-900 mt-1">{{ $contact->company }}</p>
                    </div>
                @endif
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">IP</span>
                    <p class="text-sm text-gray-900 mt-1">{{ $contact->ip_address ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <span class="text-xs text-gray-400 uppercase tracking-wider">Assunto</span>
                <h3 class="text-base font-semibold text-gray-900 mt-1 mb-3">{{ $contact->subject }}</h3>
                <span class="text-xs text-gray-400 uppercase tracking-wider">Mensagem</span>
                <div class="mt-1 text-sm text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 rounded-lg p-4">{{ $contact->message }}</div>
            </div>
        </div>

        {{-- Formulário de Resposta --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <svg class="w-5 h-5 inline-block mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                Responder
            </h3>
            <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Assunto</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject', 'Re: ' . $contact->subject) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensagem <span class="text-red-500">*</span></label>
                    <textarea name="message" id="message" rows="6" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Digite sua resposta...">{{ old('message') }}</textarea>
                    @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Enviar Resposta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
