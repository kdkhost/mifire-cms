<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiFire CMS - Offline</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes flicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .fire-flicker {
            animation: flicker 2s ease-in-out infinite;
        }
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="text-center max-w-md mx-auto">
        {{-- Fire Logo --}}
        <div class="mb-8 pulse-slow">
            <svg class="w-28 h-28 mx-auto fire-flicker" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="48" fill="#991B1B" stroke="#DC2626" stroke-width="2"/>
                <path d="M50 20 C50 20, 30 45, 30 60 C30 72, 38 80, 50 80 C62 80, 70 72, 70 60 C70 45, 50 20, 50 20Z" fill="#DC2626"/>
                <path d="M50 35 C50 35, 40 50, 40 58 C40 65, 44 70, 50 70 C56 70, 60 65, 60 58 C60 50, 50 35, 50 35Z" fill="#F87171"/>
                <path d="M50 48 C50 48, 45 55, 45 59 C45 63, 47 65, 50 65 C53 65, 55 63, 55 59 C55 55, 50 48, 50 48Z" fill="#FCA5A5"/>
            </svg>
        </div>

        {{-- Brand Name --}}
        <h1 class="text-4xl font-bold text-white mb-2">
            Mi<span class="text-red-500">Fire</span> CMS
        </h1>

        {{-- Offline Message --}}
        <div class="bg-gray-800 rounded-2xl p-8 mt-6 border border-gray-700 shadow-2xl">
            <div class="mb-4">
                <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M18.364 5.636a9 9 0 11-12.728 0M12 9v4m0 4h.01"/>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-white mb-3">Você está offline</h2>
            <p class="text-gray-400 mb-6 leading-relaxed">
                Parece que você perdeu a conexão com a internet. Verifique sua conexão e tente novamente.
            </p>

            <button onclick="window.location.reload()"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-lg shadow-red-600/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Tentar Novamente
            </button>
        </div>

        {{-- Footer --}}
        <p class="text-gray-600 text-sm mt-8">
            &copy; {{ date('Y') }} MiFire CMS &mdash; KDKHost Soluções
        </p>
    </div>
</body>
</html>
