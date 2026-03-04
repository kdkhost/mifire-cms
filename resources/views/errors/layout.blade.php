<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MiFire</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        [x-cloak] {
            display: none !important;
        }

        .error-page {
            background-color: #030712;
            color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            animation: pulse-glow 4s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from {
                opacity: 0.5;
                transform: translate(-50%, -50%) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1.1);
            }
        }

        .content-card {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 2rem;
            animation: slide-up 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-code {
            font-size: 10rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ef4444 0%, #991b1b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.05em;
            display: inline-block;
            position: relative;
        }

        .ico-fire {
            animation: fire-flicker 1.5s ease-in-out infinite;
            display: inline-block;
            margin-bottom: 2rem;
            font-size: 4rem;
            color: #dc2626;
        }

        @keyframes fire-flicker {

            0%,
            100% {
                transform: scale(1);
                filter: drop-shadow(0 0 10px rgba(220, 38, 38, 0.5));
            }

            50% {
                transform: scale(1.1);
                filter: drop-shadow(0 0 25px rgba(220, 38, 38, 0.8));
            }
        }

        .btn-home {
            background-color: #dc2626;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .btn-home:hover {
            background-color: #b91c1c;
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.4);
        }
    </style>
</head>

<body class="error-page">
    <div class="bg-glow"></div>

    <div class="content-card">
        <div class="ico-fire">
            <i class="fas fa-fire-extinguisher"></i>
        </div>

        <h1 class="error-code">@yield('code')</h1>
        <h2 class="text-2xl md:text-3xl font-bold mb-4 uppercase tracking-tight">@yield('message')</h2>
        <p class="text-gray-400 max-w-md mx-auto mb-8">
            @yield('description')
        </p>

        <a href="/" class="btn-home">
            <i class="fas fa-arrow-left"></i>
            Voltar ao Início
        </a>

        <div class="mt-12">
            <img src="{{ asset('storage/' . \App\Models\Setting::get('logo_white')) }}" alt="MiFire"
                class="h-8 mx-auto opacity-30">
        </div>
    </div>
</body>

</html>