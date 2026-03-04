@extends('install.layout', ['currentStep' => 4])

@section('title', 'Criar Administrador')
@section('subtitle', 'Crie a conta de administrador principal do sistema.')

@section('content')
    <form action="{{ route('install.admin.save') }}" method="POST" id="adminForm">
        @csrf

        <div class="space-y-4">
            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nome Completo</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $admin['name'] ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="Seu nome completo"
                       required>
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">E-mail</label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email', $admin['email'] ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="admin@seudominio.com.br"
                       required>
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Senha</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="Mínimo 8 caracteres"
                       required
                       minlength="8">
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Senha</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="Repita a senha"
                       required
                       minlength="8">
            </div>
        </div>

        <div class="mt-5 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <p class="text-sm text-blue-800">
                <strong>Importante:</strong> Guarde essas credenciais em local seguro.
                Elas serão usadas para acessar o painel administrativo do CMS.
            </p>
        </div>
    </form>
@endsection

@section('footer')
    <a href="{{ route('install.database') }}"
       class="inline-flex items-center px-5 py-2.5 border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold rounded-lg transition-colors text-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar
    </a>
    <button type="submit" form="adminForm"
            class="inline-flex items-center px-6 py-2.5 bg-mifire-600 hover:bg-mifire-700 text-white font-semibold rounded-lg transition-colors text-sm">
        Próximo
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
@endsection
