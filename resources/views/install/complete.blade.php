@extends('install.layout', ['currentStep' => 7])

@section('title', 'Instalação Concluída!')
@section('subtitle', 'O MiFire CMS foi instalado com sucesso.')

@section('content')
    <div class="text-center py-6">
        {{-- Success Icon --}}
        <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h3 class="text-2xl font-bold text-gray-800 mb-2">Tudo pronto!</h3>
        <p class="text-gray-600 mb-8">
            Seu CMS MiFire foi instalado e configurado com sucesso.<br>
            Agora você pode acessar o painel administrativo.
        </p>

        {{-- Summary --}}
        <div class="bg-gray-50 rounded-xl p-5 text-left mb-8 max-w-md mx-auto">
            <h4 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Resumo da Instalação</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Migrações</span>
                    <span class="text-green-600 font-semibold">Executadas</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Dados Iniciais</span>
                    <span class="text-green-600 font-semibold">Populados</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Administrador</span>
                    <span class="text-green-600 font-semibold">Criado</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Configurações</span>
                    <span class="text-green-600 font-semibold">Salvas</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Storage Link</span>
                    <span class="text-green-600 font-semibold">Criado</span>
                </div>
            </div>
        </div>

        {{-- Security Warning --}}
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-left max-w-md mx-auto">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <div>
                    <p class="text-sm text-amber-800">
                        <strong>Segurança:</strong> O instalador foi desativado automaticamente.
                        O arquivo <code class="bg-amber-100 px-1 rounded font-mono text-xs">storage/installed</code>
                        impede que ele seja acessado novamente.
                    </p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="/"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold rounded-lg transition-colors text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Ir para o Site
            </a>
            <a href="/admin"
               class="inline-flex items-center justify-center px-6 py-3 bg-mifire-600 hover:bg-mifire-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-lg shadow-mifire-600/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Acessar Painel Admin
            </a>
        </div>
    </div>
@endsection
