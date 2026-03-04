<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção - {{ $settings['site_name'] ?? 'MiFire' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-fire-gradient {
            background: radial-gradient(circle at top right, #450a0a, #111827);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body class="bg-fire-gradient text-white min-h-screen flex items-center justify-center p-6 overflow-hidden">
    <div class="max-w-xl w-full text-center relative z-10">
        {{-- Logo --}}
        <div class="mb-12 animate-float">
            @if(!empty($settings['logo_white']))
                <img src="{{ asset('storage/' . $settings['logo_white']) }}" alt="{{ $settings['site_name'] ?? 'MiFire' }}"
                    class="h-20 mx-auto">
            @else
                <span class="text-5xl font-black tracking-tighter">
                    Mi<span class="text-red-600">Fire</span>
                </span>
            @endif
        </div>

        {{-- Icon --}}
        <div class="mb-8">
            <div
                class="w-24 h-24 bg-red-600/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-500/30">
                <i class="fas fa-tools text-red-500 text-4xl animate-pulse"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold mb-4 tracking-tight">Estamos em Manutenção</h1>
            <p class="text-gray-400 text-lg leading-relaxed mb-10">
                Estamos preparando novidades e realizando melhorias para melhor atendê-lo.
                Voltaremos em breve com um site ainda mais completo e seguro.
            </p>
        </div>

        {{-- Contacts --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-12">
            @if(!empty($settings['whatsapp']))
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings['whatsapp']) }}" target="_blank"
                    class="bg-white/5 hover:bg-white/10 border border-white/10 p-4 rounded-2xl transition-all group">
                    <i class="fab fa-whatsapp text-green-500 text-2xl mb-2 block"></i>
                    <span class="text-sm font-medium text-gray-300 block">WhatsApp</span>
                    <span class="text-xs text-gray-500">{{ $settings['whatsapp'] }}</span>
                </a>
            @endif
            @if(!empty($settings['email']))
                <a href="mailto:{{ $settings['email'] }}"
                    class="bg-white/5 hover:bg-white/10 border border-white/10 p-4 rounded-2xl transition-all group">
                    <i class="fas fa-envelope text-red-500 text-2xl mb-2 block"></i>
                    <span class="text-sm font-medium text-gray-300 block">E-mail</span>
                    <span class="text-xs text-gray-500">{{ $settings['email'] }}</span>
                </a>
            @endif
        </div>

        <div class="text-gray-500 text-xs font-medium uppercase tracking-widest">
            &copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'MiFire' }} - Protegendo o que importa.
        </div>
    </div>

    {{-- Decor --}}
    <div class="fixed -bottom-20 -left-20 w-80 h-80 bg-red-600/10 rounded-full blur-[100px]"></div>
    <div class="fixed -top-20 -right-20 w-80 h-80 bg-red-900/10 rounded-full blur-[100px]"></div>
</body>

</html>