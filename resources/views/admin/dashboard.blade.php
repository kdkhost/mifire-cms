@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    {{-- ==================== STATS CARDS ==================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">
        {{-- Visitas Hoje --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Hoje</span>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($visitsToday ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-1">Visitas Hoje</p>
        </div>

        {{-- Visitas Mês --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">Mês</span>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($visitsMonth ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-1">Visitas no Mês</p>
        </div>

        {{-- Contatos Não Lidos --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                @if (($unreadContacts ?? 0) > 0)
                    <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Novo!</span>
                @endif
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($unreadContacts ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-1">Contatos Não Lidos</p>
        </div>

        {{-- Total Produtos --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Produtos</p>
        </div>

        {{-- Total Posts --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalPosts ?? 0) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Posts</p>
        </div>
    </div>

    {{-- ==================== CHARTS ==================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Visits Line Chart (2/3 width) --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Visitas - Últimos 30 dias</h3>
                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse" title="Dados em tempo real"></div>
            </div>
            <div class="relative" style="height: 300px;">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>

        {{-- Browsers Pie Chart (1/3 width) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Navegadores</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="browsersChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ==================== TABLES ==================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Contacts --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Contatos Recentes</h3>
                <a href="{{ route('admin.contacts.index') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">
                    Ver todos &rarr;
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Nome</th>
                            <th class="px-6 py-3">Assunto</th>
                            <th class="px-6 py-3">Data</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recentContacts ?? [] as $contact)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $contact->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $contact->email }}</p>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">
                                    {{ Str::limit($contact->subject, 30) }}
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-500">
                                    {{ $contact->created_at->format('d/m H:i') }}
                                </td>
                                <td class="px-6 py-3">
                                    @if ($contact->read_at)
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                            Lido
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                            Novo
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400">
                                    Nenhum contato recente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Pages --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Top 10 Páginas</h3>
                <a href="{{ route('admin.visits.index') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">
                    Ver todas &rarr;
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Página</th>
                            <th class="px-6 py-3 text-right">Visitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($topPages ?? [] as $index => $page)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 text-sm font-medium text-gray-400">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-3">
                                    <p class="text-sm font-medium text-gray-900 truncate max-w-xs" title="{{ $page->url }}">
                                        {{ $page->url }}
                                    </p>
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <span class="text-sm font-semibold text-gray-900">{{ number_format($page->total) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400">
                                    Nenhuma visita registrada ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    loadChartData();
});

async function loadChartData() {
    try {
        const response = await fetch('/admin/dashboard/chart-data', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        });

        if (!response.ok) throw new Error('Falha ao carregar dados');

        const data = await response.json();

        renderVisitsChart(data.visits || { labels: [], data: [] });
        renderBrowsersChart(data.browsers || { labels: [], data: [] });
    } catch (error) {
        console.error('Erro ao carregar dados do dashboard:', error);
        renderVisitsChart({ labels: [], data: [] });
        renderBrowsersChart({ labels: [], data: [] });
    }
}

function renderVisitsChart(visitsData) {
    const ctx = document.getElementById('visitsChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: visitsData.labels,
            datasets: [{
                label: 'Visitas',
                data: visitsData.data,
                borderColor: '#DC2626',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#DC2626',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 3,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleColor: '#F9FAFB',
                    bodyColor: '#D1D5DB',
                    borderColor: '#374151',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11 } },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#F3F4F6' },
                    ticks: {
                        color: '#9CA3AF',
                        font: { size: 11 },
                        precision: 0,
                    },
                },
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });
}

function renderBrowsersChart(browsersData) {
    const ctx = document.getElementById('browsersChart');
    if (!ctx) return;

    const colors = ['#DC2626', '#2563EB', '#059669', '#D97706', '#7C3AED', '#EC4899', '#6B7280'];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: browsersData.labels,
            datasets: [{
                data: browsersData.data,
                backgroundColor: colors.slice(0, browsersData.labels.length),
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 16,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 12 },
                        color: '#6B7280',
                    },
                },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleColor: '#F9FAFB',
                    bodyColor: '#D1D5DB',
                    borderColor: '#374151',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                            return ` ${context.label}: ${context.raw} (${percentage}%)`;
                        }
                    }
                }
            },
        }
    });
}
</script>
@endpush
