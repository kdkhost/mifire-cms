@extends('admin.layout')

@section('title', 'Contatos')

@section('content')
<div x-data="{ filter: '{{ request('filter', 'all') }}' }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Contatos</h1>
            <p class="text-sm text-gray-500 mt-1">Mensagens recebidas pelo formulário de contato</p>
        </div>
        <a href="{{ route('admin.contacts.export') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Exportar CSV
        </a>
    </div>

    {{-- Filtros --}}
    <div class="flex gap-2 mb-4">
        <a href="{{ route('admin.contacts.index') }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('filter') || request('filter') === 'all' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
            Todos
        </a>
        <a href="{{ route('admin.contacts.index', ['filter' => 'unread']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('filter') === 'unread' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
            Não lidos
        </a>
        <a href="{{ route('admin.contacts.index', ['filter' => 'read']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('filter') === 'read' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
            Lidos
        </a>
        <a href="{{ route('admin.contacts.index', ['filter' => 'replied']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('filter') === 'replied' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
            Respondidos
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Nome</th>
                        <th class="px-6 py-3 font-medium">E-mail</th>
                        <th class="px-6 py-3 font-medium">Assunto</th>
                        <th class="px-6 py-3 font-medium">Data</th>
                        <th class="px-6 py-3 font-medium text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($contacts as $contact)
                        <tr class="{{ !$contact->is_read ? 'bg-red-50/40 font-medium' : '' }} hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                @if($contact->replied_at)
                                    <span class="inline-flex items-center gap-1 text-xs text-blue-700 bg-blue-100 px-2 py-1 rounded-full">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                        Respondido
                                    </span>
                                @elseif($contact->is_read)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5"/></svg>
                                        Lido
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs text-red-700 bg-red-100 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        Novo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-900">{{ $contact->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $contact->email }}</td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $contact->subject }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Ver">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <button onclick="confirmDelete({{ $contact->id }}, '{{ addslashes($contact->name) }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Excluir">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Nenhum contato encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contacts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $contacts->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<form id="delete-form" method="POST" class="hidden">@csrf @method('DELETE')</form>

@push('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Excluir contato?',
            html: `A mensagem de <strong>${name}</strong> será removida permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = `{{ url('admin/contacts') }}/${id}`;
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection
