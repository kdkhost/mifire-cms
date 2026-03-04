@extends('admin.layout')

@section('title', 'Banners')

@section('content')
    <div>
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Banners</h1>
                <p class="text-sm text-gray-500 mt-1">Gerencie os banners do slider principal</p>
            </div>
            <a href="{{ route('admin.banners.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Banner
            </a>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="banners-grid">
            @forelse($banners as $banner)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden group"
                    data-id="{{ $banner->id }}">
                    {{-- Image --}}
                    <div class="relative aspect-video bg-gray-100">
                        @if($banner->image)
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        {{-- Overlay --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.banners.edit', $banner) }}"
                                    class="p-2 bg-white/90 text-gray-700 rounded-lg hover:bg-white transition-colors"
                                    title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button onclick="confirmDelete({{ $banner->id }}, '{{ addslashes($banner->title) }}')"
                                    class="p-2 bg-white/90 text-red-600 rounded-lg hover:bg-white transition-colors"
                                    title="Excluir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        {{-- Status Badge --}}
                        <div class="absolute top-3 right-3">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $banner->is_active ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                                {{ $banner->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                        {{-- Drag Handle --}}
                        <div class="absolute top-3 left-3 cursor-grab active:cursor-grabbing drag-handle">
                            <span class="inline-flex items-center p-1.5 bg-white/90 rounded-lg">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="9" cy="6" r="1.5" />
                                    <circle cx="15" cy="6" r="1.5" />
                                    <circle cx="9" cy="12" r="1.5" />
                                    <circle cx="15" cy="12" r="1.5" />
                                    <circle cx="9" cy="18" r="1.5" />
                                    <circle cx="15" cy="18" r="1.5" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    {{-- Info --}}
                    <div class="p-4">
                        <h3 class="font-medium text-gray-900 truncate">{{ $banner->title }}</h3>
                        @if($banner->subtitle)
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $banner->subtitle }}</p>
                        @endif
                        @if($banner->button_text)
                            <div class="mt-2">
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 text-red-600 text-xs rounded">
                                    {{ $banner->button_text }} &rarr; {{ Str::limit($banner->button_url, 30) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Nenhum banner cadastrado.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <form id="delete-form" method="POST" class="hidden">@csrf @method('DELETE')</form>

    @push('scripts')
        <script>
            function confirmDelete(id, title) {
                Swal.fire({
                    title: 'Excluir banner?',
                    html: `O banner <strong>${title}</strong> será removido permanentemente.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sim, excluir',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('delete-form');
                        form.action = `{{ url('admin/banners') }}/${id}`;
                        form.submit();
                    }
                });
            }

            // Drag reorder
            document.addEventListener('DOMContentLoaded', function () {
                const grid = document.getElementById('banners-grid');
                if (!grid) return;
                let dragEl = null;

                grid.querySelectorAll('[data-id]').forEach(card => {
                    card.draggable = true;
                    card.addEventListener('dragstart', (e) => { dragEl = card; card.classList.add('opacity-50'); e.dataTransfer.effectAllowed = 'move'; });
                    card.addEventListener('dragend', () => { card.classList.remove('opacity-50'); dragEl = null; });
                    card.addEventListener('dragover', (e) => { e.preventDefault(); e.dataTransfer.dropEffect = 'move'; });
                    card.addEventListener('drop', (e) => {
                        e.preventDefault();
                        if (dragEl !== card) {
                            const cards = [...grid.querySelectorAll('[data-id]')];
                            const from = cards.indexOf(dragEl), to = cards.indexOf(card);
                            if (from < to) card.after(dragEl); else card.before(dragEl);
                            const ids = [...grid.querySelectorAll('[data-id]')].map((c, idx) => ({ id: parseInt(c.dataset.id), order: idx }));
                            fetch('{{ route("admin.banners.reorder") }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                                body: JSON.stringify({ items: ids })
                            }).catch(console.error);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection