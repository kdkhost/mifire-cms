@extends('admin.layout')

@section('title', 'Categorias')

@section('content')
<div x-data="{ activeTab: '{{ request('type', 'product') }}' }">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Categorias</h1>
            <p class="text-sm text-gray-500 mt-1">Organize seus conteúdos por categorias</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nova Categoria
        </a>
    </div>

    {{-- Type Tabs --}}
    <div class="flex gap-1 bg-white rounded-xl shadow-sm border border-gray-200 p-1 mb-6 w-fit">
        @foreach(['product' => 'Produtos', 'blog' => 'Blog', 'download' => 'Downloads'] as $type => $label)
            <a href="{{ route('admin.categories.index', ['type' => $type]) }}"
               @click="activeTab = '{{ $type }}'"
               class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('type', 'product') === $type ? 'bg-red-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" id="categories-table">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold w-10">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </th>
                        <th class="px-6 py-3 font-semibold">Imagem</th>
                        <th class="px-6 py-3 font-semibold">Nome</th>
                        <th class="px-6 py-3 font-semibold">Pai</th>
                        <th class="px-6 py-3 font-semibold text-center">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="sortable-categories">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $category->id }}">
                            <td class="px-6 py-4 cursor-grab active:cursor-grabbing">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><circle cx="9" cy="6" r="1.5"/><circle cx="15" cy="6" r="1.5"/><circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/><circle cx="9" cy="18" r="1.5"/><circle cx="15" cy="18" r="1.5"/></svg>
                            </td>
                            <td class="px-6 py-4">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $category->name }}
                                <span class="block text-xs text-gray-400 mt-0.5">{{ $category->slug }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $category->parent?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $category->is_active ? 'Ativa' : 'Inativa' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-colors" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button onclick="confirmDelete({{ $category->id }}, '{{ addslashes($category->name) }}')" class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors" title="Excluir">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                                Nenhuma categoria encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $categories->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Delete Form --}}
<form id="delete-form" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Excluir categoria?',
            html: `A categoria <strong>${name}</strong> será removida permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = `{{ url('admin/categories') }}/${id}`;
                form.submit();
            }
        });
    }

    // Drag reorder using native HTML5 Drag & Drop
    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.getElementById('sortable-categories');
        if (!tbody) return;

        let dragEl = null;

        tbody.querySelectorAll('tr[data-id]').forEach(row => {
            row.draggable = true;

            row.addEventListener('dragstart', (e) => {
                dragEl = row;
                row.classList.add('opacity-50');
                e.dataTransfer.effectAllowed = 'move';
            });

            row.addEventListener('dragend', () => {
                row.classList.remove('opacity-50');
                dragEl = null;
            });

            row.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
            });

            row.addEventListener('drop', (e) => {
                e.preventDefault();
                if (dragEl !== row) {
                    const rows = [...tbody.querySelectorAll('tr[data-id]')];
                    const fromIdx = rows.indexOf(dragEl);
                    const toIdx = rows.indexOf(row);
                    if (fromIdx < toIdx) {
                        row.after(dragEl);
                    } else {
                        row.before(dragEl);
                    }
                    saveOrder();
                }
            });
        });

        function saveOrder() {
            const ids = [...tbody.querySelectorAll('tr[data-id]')].map(r => r.dataset.id);
            fetch('{{ route("admin.categories.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ ids })
            });
        }
    });
</script>
@endpush
@endsection
