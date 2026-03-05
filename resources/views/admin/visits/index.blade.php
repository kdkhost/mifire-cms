@extends('admin.layout')

@section('title', 'Visitas')

@section('content')
    <div x-data="visitsPage()">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Visitas</h1>
                <p class="text-sm text-gray-500 mt-1">Acompanhe o tráfego em tempo real</p>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" class="flex items-center gap-2">
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white">
                    <span class="text-gray-400 text-xs font-bold uppercase tracking-tight">até</span>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white">
                    <button type="submit"
                        class="px-5 py-2 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-black transition-all shadow-sm">
                        Filtrar
                    </button>
                </form>
                <a href="{{ route('admin.visits.export', request()->all()) }}"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition-all shadow-md shadow-emerald-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Exportar CSV
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Hoje</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['today'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Esta Semana</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['week'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Este Mês</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['month'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-sm font-medium text-gray-700 mb-4">Visitas (últimos 30 dias)</h3>
            <div style="height: 250px;">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>

        {{-- Tabela --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3 font-medium">URL</th>
                            <th class="px-6 py-3 font-medium">IP</th>
                            <th class="px-6 py-3 font-medium">Navegador</th>
                            <th class="px-6 py-3 font-medium">Dispositivo</th>
                            <th class="px-6 py-3 font-medium">Localização</th>
                            <th class="px-6 py-3 font-medium">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($visits as $visit)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 text-gray-900 max-w-xs truncate" title="{{ $visit->url }}">
                                    {{ $visit->url }}</td>
                                <td class="px-6 py-3 text-gray-600 font-mono text-xs">{{ $visit->ip_address }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $visit->browser ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-600">
                                    @if($visit->device === 'mobile')
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            Mobile
                                        </span>
                                    @elseif($visit->device === 'tablet')
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-purple-50 text-purple-700 px-2 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            Tablet
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-gray-50 text-gray-700 px-2 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Desktop
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-600">
                                    {{ $visit->city ? $visit->city . ', ' . $visit->country : ($visit->country ?? '-') }}</td>
                                <td class="px-6 py-3 text-gray-500 whitespace-nowrap">
                                    {{ $visit->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    Nenhuma visita registrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($visits->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $visits->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function visitsPage() {
                return {};
            }

            document.addEventListener('DOMContentLoaded', function () {
                const chartData = @json($chartData ?? ['labels' => [], 'data' => []]);
                const ctx = document.getElementById('visitsChart');
                if (ctx) {
                    new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: chartData.labels,
                            datasets: [{
                                label: 'Visitas',
                                data: chartData.data,
                                borderColor: '#dc2626',
                                backgroundColor: 'rgba(220, 38, 38, 0.08)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#dc2626',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 3,
                                pointHoverRadius: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f3f4f6' } },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection