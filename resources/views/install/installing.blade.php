@extends('install.layout', ['currentStep' => 6])

@section('title', 'Instalando...')
@section('subtitle', 'Aguarde enquanto o sistema é configurado.')

@section('content')
    <div id="install-progress" class="space-y-4">
        {{-- Progress Bar --}}
        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
            <div id="progressBar" class="bg-gradient-to-r from-mifire-500 to-mifire-700 h-3 rounded-full transition-all duration-500 ease-out" style="width: 0%"></div>
        </div>

        {{-- Status Messages --}}
        <div id="statusArea" class="min-h-[200px] bg-gray-50 rounded-xl p-4 font-mono text-xs text-gray-600 overflow-y-auto max-h-[300px]">
            <p class="text-gray-400">Iniciando instalação...</p>
        </div>

        {{-- Current Task --}}
        <div class="flex items-center justify-center py-2">
            <svg id="spinner" class="animate-spin w-5 h-5 text-mifire-600 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span id="currentTask" class="text-sm font-medium text-gray-700">Preparando instalação...</span>
        </div>

        {{-- Error Container (hidden by default) --}}
        <div id="errorContainer" class="hidden bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-bold text-red-800">Erro na instalação</p>
                    <p id="errorMessage" class="text-sm text-red-700 mt-1"></p>
                </div>
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('install.database') }}"
                   class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors text-sm">
                    Voltar e Corrigir
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const progressBar = document.getElementById('progressBar');
            const statusArea = document.getElementById('statusArea');
            const currentTask = document.getElementById('currentTask');
            const spinner = document.getElementById('spinner');
            const errorContainer = document.getElementById('errorContainer');
            const errorMessage = document.getElementById('errorMessage');

            const tasks = [
                { progress: 10, message: 'Configurando arquivo .env...' },
                { progress: 20, message: 'Conectando ao banco de dados...' },
                { progress: 40, message: 'Executando migrações...' },
                { progress: 60, message: 'Populando dados iniciais...' },
                { progress: 75, message: 'Criando usuário administrador...' },
                { progress: 85, message: 'Configurando armazenamento...' },
                { progress: 95, message: 'Limpando caches...' },
            ];

            function addStatus(msg, isError = false) {
                const p = document.createElement('p');
                p.textContent = '> ' + msg;
                p.className = isError ? 'text-red-600 font-bold' : 'text-green-700';
                statusArea.appendChild(p);
                statusArea.scrollTop = statusArea.scrollHeight;
            }

            // Simulate progress while waiting for AJAX
            let taskIndex = 0;
            const progressInterval = setInterval(() => {
                if (taskIndex < tasks.length) {
                    const task = tasks[taskIndex];
                    progressBar.style.width = task.progress + '%';
                    currentTask.textContent = task.message;
                    addStatus(task.message);
                    taskIndex++;
                }
            }, 800);

            // Execute installation via AJAX
            setTimeout(() => {
                fetch('{{ route('install.execute') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json().then(data => ({ ok: response.ok, data })))
                .then(({ ok, data }) => {
                    clearInterval(progressInterval);

                    if (ok && data.success) {
                        progressBar.style.width = '100%';
                        currentTask.textContent = 'Instalação concluída!';
                        addStatus('Instalação concluída com sucesso!');
                        spinner.classList.add('hidden');

                        setTimeout(() => {
                            window.location.href = '{{ route('install.complete') }}';
                        }, 1500);
                    } else {
                        spinner.classList.add('hidden');
                        errorContainer.classList.remove('hidden');
                        errorMessage.textContent = data.message || 'Erro desconhecido durante a instalação.';
                        addStatus(data.message || 'Erro desconhecido', true);
                    }
                })
                .catch(error => {
                    clearInterval(progressInterval);
                    spinner.classList.add('hidden');
                    errorContainer.classList.remove('hidden');
                    errorMessage.textContent = 'Erro de comunicação: ' + error.message;
                    addStatus('Erro de comunicação: ' + error.message, true);
                });
            }, 500);
        });
    </script>
@endsection
