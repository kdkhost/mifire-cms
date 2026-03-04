<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalação - MiFire CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        mifire: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                            950: '#450a0a',
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .step-active {
            background: linear-gradient(135deg, #dc2626, #991b1b);
            color: white;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.3);
        }
        .step-completed {
            background: #16a34a;
            color: white;
        }
        .step-pending {
            background: #e5e7eb;
            color: #9ca3af;
        }
        .connector-completed { background-color: #16a34a; }
        .connector-pending { background-color: #e5e7eb; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-mifire-600 via-mifire-700 to-mifire-950">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">

        {{-- Logo / Title --}}
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-extrabold text-white tracking-tight">
                Mi<span class="text-mifire-200">Fire</span>
            </h1>
            <p class="text-mifire-200 text-sm mt-1">Sistema de Gerenciamento de Conteúdo</p>
        </div>

        {{-- Steps Indicator --}}
        @php
            $steps = [
                1 => 'Requisitos',
                2 => 'Permissões',
                3 => 'Banco de Dados',
                4 => 'Administrador',
                5 => 'Configurações',
                6 => 'Instalação',
                7 => 'Concluído',
            ];
            $currentStep = $currentStep ?? 1;
        @endphp

        <div class="mb-6 w-full max-w-3xl">
            <div class="flex items-center justify-center">
                @foreach ($steps as $num => $label)
                    {{-- Step Circle --}}
                    <div class="flex flex-col items-center">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300
                            {{ $num < $currentStep ? 'step-completed' : ($num === $currentStep ? 'step-active' : 'step-pending') }}">
                            @if ($num < $currentStep)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                {{ $num }}
                            @endif
                        </div>
                        <span class="text-[10px] mt-1 font-medium {{ $num <= $currentStep ? 'text-white' : 'text-mifire-300' }} hidden sm:block">
                            {{ $label }}
                        </span>
                    </div>

                    {{-- Connector Line --}}
                    @if ($num < count($steps))
                        <div class="w-6 sm:w-10 h-0.5 mx-1 mt-[-12px] sm:mt-[-12px] rounded
                            {{ $num < $currentStep ? 'connector-completed' : 'connector-pending' }}">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Main Card --}}
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-gray-50 border-b border-gray-200 px-8 py-5">
                <h2 class="text-xl font-bold text-gray-800">@yield('title')</h2>
                <p class="text-sm text-gray-500 mt-1">@yield('subtitle')</p>
            </div>

            {{-- Card Body --}}
            <div class="px-8 py-6">
                @if ($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p class="text-sm text-red-700">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>

            {{-- Card Footer --}}
            @hasSection('footer')
                <div class="bg-gray-50 border-t border-gray-200 px-8 py-4 flex justify-between items-center">
                    @yield('footer')
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <p class="mt-6 text-mifire-200 text-xs">&copy; {{ date('Y') }} MiFire CMS. Instalador v1.0</p>
    </div>

</body>
</html>
