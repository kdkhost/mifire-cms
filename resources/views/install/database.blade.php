@extends('install.layout', ['currentStep' => 3])

@section('title', 'Configuração do Banco de Dados')
@section('subtitle', 'Informe os dados de conexão com o banco de dados MariaDB.')

@section('content')
    <form action="{{ route('install.database.save') }}" method="POST" id="dbForm">
        @csrf

        <div class="space-y-4">
            {{-- Host --}}
            <div>
                <label for="host" class="block text-sm font-semibold text-gray-700 mb-1">Host do Banco de Dados</label>
                <input type="text"
                       name="host"
                       id="host"
                       value="{{ old('host', $db['host'] ?? '127.0.0.1') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="127.0.0.1 ou localhost"
                       required>
                @error('host')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Port --}}
            <div>
                <label for="port" class="block text-sm font-semibold text-gray-700 mb-1">Porta</label>
                <input type="text"
                       name="port"
                       id="port"
                       value="{{ old('port', $db['port'] ?? '3306') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="3306"
                       required>
                @error('port')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Database Name --}}
            <div>
                <label for="database" class="block text-sm font-semibold text-gray-700 mb-1">Nome do Banco de Dados</label>
                <input type="text"
                       name="database"
                       id="database"
                       value="{{ old('database', $db['database'] ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="mifire_cms"
                       required>
                @error('database')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">No cPanel, o nome geralmente segue o formato: usuario_nomedobanco</p>
            </div>

            {{-- Username --}}
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Usuário do Banco</label>
                <input type="text"
                       name="username"
                       id="username"
                       value="{{ old('username', $db['username'] ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="usuario_cms"
                       required>
                @error('username')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Senha do Banco</label>
                <input type="password"
                       name="password"
                       id="password"
                       value="{{ old('password', $db['password'] ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-5 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <p class="text-sm text-blue-800">
                <strong>Dica cPanel:</strong> Crie o banco de dados e o usuário pelo menu
                <em>MariaDB Databases</em> do cPanel antes de prosseguir. Não esqueça de associar o usuário ao banco
                com <strong>ALL PRIVILEGES</strong>.
            </p>
        </div>
    </form>
@endsection

@section('footer')
    <a href="{{ route('install.permissions') }}"
       class="inline-flex items-center px-5 py-2.5 border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold rounded-lg transition-colors text-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar
    </a>
    <button type="submit" form="dbForm"
            class="inline-flex items-center px-6 py-2.5 bg-mifire-600 hover:bg-mifire-700 text-white font-semibold rounded-lg transition-colors text-sm">
        Testar e Prosseguir
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
@endsection
