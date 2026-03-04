<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - MiFire CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        .float-animation-delay {
            animation: float 6s ease-in-out 2s infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- LEFT COLUMN - Brand / Imagery --}}
        <div class="lg:w-1/2 xl:w-[45%] bg-gradient-to-br from-red-700 via-red-800 to-red-900 relative overflow-hidden">
            {{-- Decorative background elements --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-10 w-32 h-32 border-2 border-white rounded-full"></div>
                <div class="absolute bottom-32 right-10 w-48 h-48 border-2 border-white rounded-full"></div>
                <div class="absolute top-1/2 left-1/3 w-24 h-24 border border-white rounded-full"></div>
            </div>

            {{-- Content --}}
            <div class="relative z-10 flex flex-col items-center justify-center h-full px-8 py-12 lg:py-0">
                {{-- Logo --}}
                <div class="mb-6 float-animation">
                    <svg class="w-24 h-24 lg:w-32 lg:h-32" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="46" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                        <path d="M50 18 C50 18, 28 45, 28 60 C28 73, 37 82, 50 82 C63 82, 72 73, 72 60 C72 45, 50 18, 50 18Z" fill="rgba(255,255,255,0.9)"/>
                        <path d="M50 32 C50 32, 38 50, 38 58 C38 66, 43 72, 50 72 C57 72, 62 66, 62 58 C62 50, 50 32, 50 32Z" fill="#DC2626"/>
                        <path d="M50 45 C50 45, 44 54, 44 58 C44 62, 46 65, 50 65 C54 65, 56 62, 56 58 C56 54, 50 45, 50 45Z" fill="#FCA5A5"/>
                    </svg>
                </div>

                {{-- Brand Name --}}
                <h1 class="text-4xl lg:text-5xl font-bold text-white mb-3 tracking-tight">
                    Mi<span class="text-red-300">Fire</span> CMS
                </h1>

                {{-- Tagline --}}
                <p class="text-red-200 text-lg lg:text-xl font-light text-center max-w-xs">
                    Sistema de Gerenciamento de Conteúdo
                </p>

                {{-- Decorative Icons --}}
                <div class="hidden lg:flex items-center gap-8 mt-12 text-red-300/50">
                    {{-- Shield Icon --}}
                    <div class="float-animation">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    {{-- Fire Icon --}}
                    <div class="float-animation-delay">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                        </svg>
                    </div>
                    {{-- Globe Icon --}}
                    <div class="float-animation">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Bottom gradient overlay --}}
            <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-red-900/50 to-transparent"></div>
        </div>

        {{-- RIGHT COLUMN - Form Area --}}
        <div class="flex-1 flex items-center justify-center px-6 py-12 lg:px-16">
            <div class="w-full max-w-md">
                @yield('form')
            </div>
        </div>

    </div>
</body>
</html>
