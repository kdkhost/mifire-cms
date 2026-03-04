<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - MiFire CMS Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Favicon Dinâmico --}}
    @php
        $faviconPath = \App\Models\Setting::get('site_favicon');
    @endphp
    @if($faviconPath)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $faviconPath) }}">
    @else
        <link rel="icon" type="image/png" href="/favicon.ico">
    @endif

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: false }" x-cloak>

    {{-- Mobile Sidebar Overlay --}}
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        @click="sidebarOpen = false">
    </div>

    {{-- ==================== SIDEBAR ==================== --}}
    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 xl:w-72 bg-gray-900 transform transition-transform duration-200 ease-in-out lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        {{-- Logo Area --}}
        <div class="flex items-center gap-3 h-16 px-6 border-b border-gray-800">
            <svg class="w-8 h-8 shrink-0" viewBox="0 0 100 100" fill="none">
                <circle cx="50" cy="50" r="46" fill="#991B1B" />
                <path d="M50 18C50 18 28 45 28 60C28 73 37 82 50 82C63 82 72 73 72 60C72 45 50 18 50 18Z"
                    fill="#DC2626" />
                <path d="M50 35C50 35 40 50 40 58C40 65 44 70 50 70C56 70 60 65 60 58C60 50 50 35 50 35Z"
                    fill="#F87171" />
            </svg>
            <div>
                <h1 class="text-white font-bold text-lg leading-tight">MiFire <span class="text-red-400">CMS</span></h1>
                <p class="text-gray-500 text-xs">Painel Administrativo</p>
            </div>
            {{-- Close button (mobile) --}}
            <button @click="sidebarOpen = false" class="ml-auto lg:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1" style="max-height: calc(100vh - 4rem);">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/>'],
                    ['route' => 'admin.pages.index', 'label' => 'Páginas', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                    ['route' => 'admin.categories.index', 'label' => 'Categorias', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>'],
                    ['route' => 'admin.products.index', 'label' => 'Produtos', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'],
                    ['route' => 'admin.blog.index', 'label' => 'Blog', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>'],
                    ['route' => 'admin.downloads.index', 'label' => 'Downloads', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                    ['route' => 'admin.banners.index', 'label' => 'Banners', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                    ['route' => 'admin.brands.index', 'label' => 'Marcas', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>'],
                    ['route' => 'admin.contacts.index', 'label' => 'Contatos', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'badge' => 'unread_contacts_count'],
                    ['route' => 'admin.visits.index', 'label' => 'Visitas', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                    ['route' => 'admin.menus.index', 'label' => 'Menus', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>'],
                    ['route' => 'admin.addresses.index', 'label' => 'Endereços', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                    ['route' => 'admin.contact-departments.index', 'label' => 'Departamentos', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>'],
                    ['route' => 'admin.social-links.index', 'label' => 'Redes Sociais', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>'],
                    ['route' => 'admin.email-templates.index', 'label' => 'Templates de Email', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 19V5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2zM3 7h18M7 3v4"/>'],
                    ['route' => 'admin.settings.index', 'label' => 'Configurações', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                    ['route' => 'admin.users.index', 'label' => 'Usuários', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>'],
                ];
            @endphp

            @foreach ($navItems as $item)
                    @php
                        $isActive = request()->routeIs($item['route'] . '*');
                    @endphp
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150
                                                                                  {{ $isActive
                ? 'bg-red-600 text-white shadow-lg shadow-red-600/20'
                : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                        <span>{{ $item['label'] }}</span>

                        {{-- Badge for Contacts --}}
                        @if (isset($item['badge']) && isset(${$item['badge']}) && ${$item['badge']} > 0)
                            <span
                                class="ml-auto inline-flex items-center justify-center w-5 h-5 text-xs font-bold rounded-full
                                                                                                                         {{ $isActive ? 'bg-white text-red-600' : 'bg-red-600 text-white' }}">
                                {{ ${$item['badge']} }}
                            </span>
                        @endif
                    </a>
            @endforeach
        </nav>
    </aside>

    {{-- ==================== MAIN WRAPPER ==================== --}}
    <div class="lg:pl-64 xl:pl-72 min-h-screen flex flex-col">

        {{-- ==================== TOP BAR ==================== --}}
        <header class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                {{-- Left: Hamburger + Title --}}
                <div class="flex items-center gap-4">
                    {{-- Mobile hamburger --}}
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <h2 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                </div>

                {{-- Right: Actions --}}
                <div class="flex items-center gap-3">
                    {{-- View Site --}}
                    <a href="/" target="_blank"
                        class="hidden sm:inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-red-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Ver Site
                    </a>

                    {{-- User Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-semibold">
                                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                </span>
                            </div>
                            <span class="hidden sm:block text-sm font-medium text-gray-700">
                                {{ auth()->user()->name ?? 'Admin' }}
                            </span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-1 z-50">
                            <a href="{{ route('admin.users.edit', auth()->id()) }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Meu Perfil
                            </a>
                            <a href="{{ route('admin.settings.index') }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Configurações
                            </a>
                            <hr class="my-1 border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ==================== FLASH MESSAGES ==================== --}}
        <div class="px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                    class="mt-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show"
                    class="mt-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('warning'))
                <div x-data="{ show: true }" x-show="show"
                    class="mt-4 flex items-center gap-3 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('warning') }}</span>
                    <button @click="show = false" class="ml-auto text-yellow-400 hover:text-yellow-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        {{-- ==================== MAIN CONTENT ==================== --}}
        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
            @yield('content')
        </main>

        {{-- ==================== FOOTER ==================== --}}
        <footer class="border-t border-gray-200 bg-white px-4 sm:px-6 lg:px-8 py-4">
            <p class="text-center text-sm text-gray-400">
                Desenvolvido por George Marcelo &mdash; <span class="font-medium">KDKHost Soluções</span> &copy;
                {{ date('Y') }}
            </p>
        </footer>
    </div>

    {{-- ==================== SWEETALERT & GLOBAL AJAX HANDLER ==================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Global delete confirmation
            document.querySelectorAll('[data-confirm-delete]').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    const form = this.closest('form') || document.getElementById(this.dataset.formId);
                    const itemName = this.dataset.confirmDelete || 'este item';

                    Swal.fire({
                        title: 'Tem certeza?',
                        text: `Deseja realmente excluir ${itemName}? Esta ação não pode ser desfeita.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DC2626',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Sim, excluir!',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed && form) {
                            form.submit();
                        }
                    });
                });
            });

            /**
             * GLOBAL AJAX FORM HANDLER
             * Intercepts forms with class .ajax-form
             */
            document.addEventListener('submit', function (e) {
                const form = e.target;

                if (form.classList.contains('ajax-form')) {
                    e.preventDefault();

                    const submitBtn = form.querySelector('[type="submit"]');
                    const originalBtnContent = submitBtn ? submitBtn.innerHTML : '';
                    const formData = new FormData(form);
                    const method = form.getAttribute('method') || 'POST';
                    const url = form.getAttribute('action');

                    // Disable button & show loading
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processando...';
                    }

                    Swal.fire({
                        title: 'Enviando arquivos...',
                        html: '<div class="w-full bg-gray-200 rounded-full h-2.5 mt-2 mb-1"><div id="swal-progress-bar" class="bg-red-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div></div><span id="swal-progress-text" class="text-xs text-gray-500">0%</span>',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const xhr = new XMLHttpRequest();
                    xhr.open(method, url, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    xhr.upload.addEventListener("progress", function (e) {
                        if (e.lengthComputable) {
                            const percentComplete = Math.round((e.loaded / e.total) * 100);
                            const progressBar = document.getElementById('swal-progress-bar');
                            const progressText = document.getElementById('swal-progress-text');
                            if (progressBar) progressBar.style.width = percentComplete + '%';
                            if (progressText) progressText.innerText = percentComplete + '%';
                        }
                    });

                    xhr.onload = function () {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            try {
                                const data = JSON.parse(xhr.responseText);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sucesso!',
                                    html: data.message || 'Dados salvos com sucesso.',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showConfirmButton: false
                                });

                                if (data.redirect) {
                                    setTimeout(() => window.location.href = data.redirect, 1500);
                                } else {
                                    if (window.initMasks) window.initMasks();
                                    setTimeout(() => { if (window.initDragAndDrop) window.initDragAndDrop(); }, 300);
                                }
                            } catch (e) {
                                showError('Erro ao processar resposta do servidor.');
                            }
                        } else {
                            try {
                                const data = JSON.parse(xhr.responseText);
                                if (xhr.status === 422) {
                                    showError(Object.values(data.errors).flat().join('<br>'));
                                } else {
                                    showError(data.message || 'Ocorreu um erro ao processar a requisição.');
                                }
                            } catch (e) {
                                showError('Ocorreu um erro inesperado.');
                            }
                        }
                    };

                    xhr.onerror = function () {
                        showError('Falha na comunicação com o servidor.');
                    };

                    xhr.onloadend = function () {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnContent;
                        }
                    };

                    xhr.send(formData);

                    function showError(msg) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ops!',
                            html: msg,
                            confirmButtonColor: '#DC2626',
                        });
                    }
                }
            });

            /**
             * GLOBAL DRAG-AND-DROP FILE UPLOAD HANDLER
             * Converte automaticamente inputs de file tradicionais em dropzones modernas.
             */
            window.initDragAndDrop = function () {
                const fileInputs = document.querySelectorAll('input[type="file"]:not(.dropzone-initialized)');

                fileInputs.forEach(input => {
                    input.classList.add('dropzone-initialized');
                    input.classList.add('hidden'); // Hide original input

                    // Creates wrapper
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative flex flex-col items-center justify-center p-6 mt-1 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer group overflow-hidden min-h-[140px]';

                    const placeholder = document.createElement('div');
                    placeholder.className = 'text-center z-10 pointer-events-none dropzone-content';
                    placeholder.innerHTML = `
                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-red-500 transition-colors mb-3" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Arraste um arquivo ou <span class="text-red-600">clique para selecionar</span></p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, SVG ou GIF até 2MB</p>
                    `;

                    const previewImg = document.createElement('img');
                    previewImg.className = 'absolute inset-0 w-full h-full object-contain bg-gray-900/10 backdrop-blur-sm hidden z-20 transition-opacity p-2 rounded-xl';

                    const fileNameBadge = document.createElement('span');
                    fileNameBadge.className = 'absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-black/70 text-white text-[10px] px-2 py-1 rounded-full hidden z-30 max-w-[90%] truncate';

                    const clearBtn = document.createElement('button');
                    clearBtn.type = 'button';
                    clearBtn.className = 'absolute top-2 right-2 p-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full hidden z-40 shadow-sm transition-transform hover:scale-110';
                    clearBtn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

                    input.parentNode.insertBefore(wrapper, input);
                    wrapper.appendChild(input);
                    wrapper.appendChild(placeholder);
                    wrapper.appendChild(previewImg);
                    wrapper.appendChild(fileNameBadge);
                    wrapper.appendChild(clearBtn);

                    // Image preview pre-existing check (se a view do blade já tiver gerado um img logo abaixo, tentamos importar o src dele e oculta-lo)
                    const existingImgSibling = wrapper.nextElementSibling;
                    if (existingImgSibling && existingImgSibling.tagName === 'DIV' && existingImgSibling.querySelector('img')) {
                        const imgTag = existingImgSibling.querySelector('img');
                        if (imgTag && imgTag.src) {
                            previewImg.src = imgTag.src;
                            previewImg.classList.remove('hidden');
                            placeholder.classList.add('opacity-0');
                            existingImgSibling.classList.add('hidden'); // hide the old blade preview
                        }
                    }

                    // Click propagation
                    wrapper.addEventListener('click', (e) => {
                        if (e.target !== clearBtn) {
                            input.click();
                        }
                    });

                    // Drag Events
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        wrapper.addEventListener(eventName, preventDefaults, false);
                    });

                    function preventDefaults(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }

                    ['dragenter', 'dragover'].forEach(eventName => {
                        wrapper.addEventListener(eventName, () => {
                            wrapper.classList.add('border-red-500', 'bg-red-50');
                            wrapper.classList.remove('border-gray-300', 'bg-gray-50');
                        }, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        wrapper.addEventListener(eventName, () => {
                            wrapper.classList.remove('border-red-500', 'bg-red-50');
                            wrapper.classList.add('border-gray-300', 'bg-gray-50');
                        }, false);
                    });

                    wrapper.addEventListener('drop', (e) => {
                        let dt = e.dataTransfer;
                        let files = dt.files;
                        if (files.length > 0) {
                            input.files = files; // transfer array
                            handleFiles(files[0]);
                        }
                    }, false);

                    input.addEventListener('change', function () {
                        if (this.files && this.files[0]) {
                            handleFiles(this.files[0]);
                        }
                    });

                    clearBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        input.value = '';
                        previewImg.removeAttribute('src');
                        previewImg.classList.add('hidden');
                        clearBtn.classList.add('hidden');
                        fileNameBadge.classList.add('hidden');
                        placeholder.classList.remove('opacity-0');
                    });

                    function handleFiles(file) {
                        if (!file) return;

                        // Set text
                        fileNameBadge.textContent = file.name;
                        fileNameBadge.classList.remove('hidden');
                        clearBtn.classList.remove('hidden');

                        // Check if Image for preview
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                previewImg.src = e.target.result;
                                previewImg.classList.remove('hidden');
                                placeholder.classList.add('opacity-0');
                            }
                            reader.readAsDataURL(file);
                        } else {
                            // Non-image icon fallback
                            previewImg.src = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%239CA3AF"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>';
                            previewImg.classList.remove('hidden');
                            placeholder.classList.add('opacity-0');
                        }
                    }
                });
            }

            // Run on load
            window.initDragAndDrop();
        });
    </script>
    @stack('scripts')
</body>

</html>