@extends('admin.layout')

@section('title', 'Menus')

@section('content')
<div x-data="menusPage()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Menus</h1>
            <p class="text-sm text-gray-500 mt-1">Gerencie os menus de navegação do site</p>
        </div>
        <a href="{{ route('admin.menus.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo Item
        </a>
    </div>

    {{-- Filtro por localização --}}
    <div class="flex gap-2 mb-4">
        <a href="{{ route('admin.menus.index') }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('location') ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
            Todos
        </a>
        <a href="{{ route('admin.menus.index', ['location' => 'header']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('location') === 'header' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
            Header
        </a>
        <a href="{{ route('admin.menus.index', ['location' => 'footer']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('location') === 'footer' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
            Footer
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-medium w-10">#</th>
                        <th class="px-6 py-3 font-medium">Título</th>
                        <th class="px-6 py-3 font-medium">URL / Página</th>
                        <th class="px-6 py-3 font-medium">Local</th>
                        <th class="px-6 py-3 font-medium">Pai</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="menu-list">
                    @forelse($menus as $menu)
                        <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $menu->id }}">
                            <td class="px-6 py-3 text-gray-400 cursor-grab" title="Arraste para reordenar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                            </td>
                            <td class="px-6 py-3 text-gray-900 font-medium">
                                @if($menu->icon)
                                    <i class="{{ $menu->icon }} mr-1 text-gray-400"></i>
                                @endif
                                {{ $menu->parent_id ? '— ' : '' }}{{ $menu->title }}
                            </td>
                            <td class="px-6 py-3 text-gray-600">
                                @if($menu->page)
                                    <span class="text-blue-600">{{ $menu->page->title }}</span>
                                @else
                                    {{ $menu->url ?? '-' }}
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $menu->location === 'header' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ ucfirst($menu->location) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-500">{{ $menu->parent ? $menu->parent->title : '-' }}</td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $menu->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.menus.edit', $menu) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button onclick="confirmDelete({{ $menu->id }}, '{{ addslashes($menu->title) }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Excluir">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                Nenhum item de menu cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" class="hidden">@csrf @method('DELETE')</form>

@push('scripts')
<script>
    function menusPage() {
        return {};
    }

    function confirmDelete(id, title) {
        Swal.fire({
            title: 'Excluir item?',
            html: `O item <strong>${title}</strong> será removido permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = `{{ url('admin/menus') }}/${id}`;
                form.submit();
            }
        });
    }

    // Drag & Drop Reorder
    (function() {
        const tbody = document.getElementById('menu-list');
        if (!tbody) return;
        let dragEl;
        tbody.querySelectorAll('tr[data-id]').forEach(row => {
            row.draggable = true;
            row.addEventListener('dragstart', function(e) { dragEl = this; this.classList.add('opacity-50'); });
            row.addEventListener('dragend', function() { this.classList.remove('opacity-50'); });
            row.addEventListener('dragover', function(e) { e.preventDefault(); });
            row.addEventListener('drop', function(e) {
                e.preventDefault();
                if (this !== dragEl) {
                    const rows = [...tbody.querySelectorAll('tr[data-id]')];
                    const from = rows.indexOf(dragEl);
                    const to = rows.indexOf(this);
                    if (from < to) this.after(dragEl); else this.before(dragEl);
                    saveOrder();
                }
            });
        });

        function saveOrder() {
            const ids = [...tbody.querySelectorAll('tr[data-id]')].map(r => r.dataset.id);
            fetch('{{ route("admin.menus.reorder") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ ids })
            });
        }
    })();
</script>
@endpush
@endsection
