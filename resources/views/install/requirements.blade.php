@extends('install.layout', ['currentStep' => 1])

@section('title', 'Verificação de Requisitos')
@section('subtitle', 'Verificando se o servidor atende aos requisitos mínimos do sistema.')

@section('content')
    <div class="space-y-3">
        @foreach ($requirements as $req)
            <div class="flex items-center justify-between p-3 rounded-lg {{ $req['passed'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                <div class="flex items-center">
                    @if ($req['passed'])
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @endif
                    <span class="font-medium text-sm {{ $req['passed'] ? 'text-green-800' : 'text-red-800' }}">
                        {{ $req['name'] }}
                    </span>
                </div>
                <span class="text-xs {{ $req['passed'] ? 'text-green-600' : 'text-red-600' }} font-mono">
                    {{ $req['current'] }}
                </span>
            </div>
        @endforeach
    </div>

    @unless ($allPassed)
        <div class="mt-5 bg-amber-50 border border-amber-200 rounded-xl p-4">
            <p class="text-sm text-amber-800">
                <strong>Atenção:</strong> Alguns requisitos não foram atendidos.
                Entre em contato com o administrador do servidor para instalar as extensões necessárias.
            </p>
        </div>
    @endunless
@endsection

@section('footer')
    <div></div>
    @if ($allPassed)
        <a href="{{ route('install.permissions') }}"
           class="inline-flex items-center px-6 py-2.5 bg-mifire-600 hover:bg-mifire-700 text-white font-semibold rounded-lg transition-colors text-sm">
            Próximo
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    @else
        <button disabled class="inline-flex items-center px-6 py-2.5 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed text-sm">
            Próximo
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    @endif
@endsection
