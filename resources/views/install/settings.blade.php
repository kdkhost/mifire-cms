@extends('install.layout', ['currentStep' => 5])

@section('title', 'Configurações do Site')
@section('subtitle', 'Defina as informações básicas do seu site.')

@section('content')
    <form action="{{ route('install.settings.save') }}" method="POST" id="settingsForm">
        @csrf

        <div class="space-y-4">
            {{-- Site Name --}}
            <div>
                <label for="site_name" class="block text-sm font-semibold text-gray-700 mb-1">Nome do Site</label>
                <input type="text"
                       name="site_name"
                       id="site_name"
                       value="{{ old('site_name', $settings['site_name'] ?? 'MiFire') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="MiFire"
                       required>
                @error('site_name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Site Description --}}
            <div>
                <label for="site_description" class="block text-sm font-semibold text-gray-700 mb-1">Descrição do Site</label>
                <textarea name="site_description"
                          id="site_description"
                          rows="3"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors resize-none"
                          placeholder="Uma breve descrição do seu site..."
                          required>{{ old('site_description', $settings['site_description'] ?? 'Soluções em Prevenção e Combate a Incêndio') }}</textarea>
                @error('site_description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Admin Email --}}
            <div>
                <label for="admin_email" class="block text-sm font-semibold text-gray-700 mb-1">E-mail de Administração</label>
                <input type="email"
                       name="admin_email"
                       id="admin_email"
                       value="{{ old('admin_email', $settings['admin_email'] ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mifire-500 focus:border-mifire-500 text-sm transition-colors"
                       placeholder="comercial@mat-eng.com.br"
                       required>
                @error('admin_email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Este e-mail será usado para notificações do sistema e como remetente padrão.</p>
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <a href="{{ route('install.admin') }}"
       class="inline-flex items-center px-5 py-2.5 border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold rounded-lg transition-colors text-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Voltar
    </a>
    <button type="submit" form="settingsForm"
            class="inline-flex items-center px-6 py-2.5 bg-mifire-600 hover:bg-mifire-700 text-white font-semibold rounded-lg transition-colors text-sm">
        Próximo
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
@endsection
