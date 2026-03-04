@extends('install.layout', ['currentStep' => 2])

@section('title', 'Permissões de Diretórios')
@section('subtitle', 'Verificando permissões de escrita nos diretórios necessários.')

@section('content')
    <div class="space-y-3">
        @foreach ($permissions as $perm)
            <div class="flex items-center justify-between p-3 rounded-lg {{ $perm['passed'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                <div class="flex items-center">
                    @if ($perm['passed'])
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @endif
                    <div>
                        <span class="font-medium text-sm {{ $perm['passed'] ? 'text-green-800' : 'text-red-800' }}">
                            {{ $perm['name'] }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs {{ $perm['passed'] ? 'text-green-600' : 'text-red-600' }} font-mono">
                        {{ $perm['current'] }}
                    </span>
                    <span class="block text-[10px] {{ $perm['passed'] ? 'text-green-500' : 'text-red-500' }}">
                        {{ $perm['passed'] ? 'Gravável' : 'Sem permissão' }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    @unless ($allPassed)
        <div class="mt-5 bg-amber-50 border border-amber-200 rounded-xl p-4">
            <p class="text-sm text-amber-800">
                <strong>Atenção:</strong> Alguns diretórios não possuem permissão de escrita.
                No cPanel, use o Gerenciador de Arquivos para definir a permissão <code class="font-mono bg-amber-100 px-1 rounded">775</code>
                nos diretórios indicados.
            </p>
        </div>
    @endunless
@endsection

@section('footer')
    <a href="{{ route('install.requirements') }}"
       class="inline-flex items-center px-5 py-2.5 border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold rounded-lg transition-colors text-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar
    </a>

    @if ($allPassed)
        <a href="{{ route('install.database') }}"
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
