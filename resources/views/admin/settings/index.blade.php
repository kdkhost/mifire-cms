@extends('admin.layout')

@section('title', 'Configurações')

@section('content')
    <div x-data="settingsPage()">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Configurações</h1>
            <p class="text-sm text-gray-500 mt-1">Gerencie as configurações gerais do site</p>
        </div>

        {{-- Tabs --}}
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex gap-1 -mb-px overflow-x-auto">
                <button @click="tab = 'geral'"
                    :class="tab === 'geral' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Geral</button>
                <button @click="tab = 'contato'"
                    :class="tab === 'contato' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Contato</button>
                <button @click="tab = 'seo'"
                    :class="tab === 'seo' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">SEO</button>
                <button @click="tab = 'pwa'"
                    :class="tab === 'pwa' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">PWA</button>
                <button @click="tab = 'email'"
                    :class="tab === 'email' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">E-mail</button>
                <button @click="tab = 'avancado'"
                    :class="tab === 'avancado' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    class="px-4 py-3 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Avançado</button>
            </nav>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="ajax-form">
            @csrf
            <div class="max-w-3xl">
                {{-- GERAL --}}
                <div x-show="tab === 'geral'" class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">Informações do Site
                        </h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Site</label>
                            <input type="text" name="settings[site_name]"
                                value="{{ old('settings.site_name', $settings['site_name'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Slogan</label>
                            <input type="text" name="settings[site_tagline]"
                                value="{{ old('settings.site_tagline', $settings['site_tagline'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                            <input type="file" name="site_logo" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
                            @if(!empty($settings['site_logo']))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo"
                                        class="h-10 object-contain">
                                </div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                            <input type="file" name="site_favicon" accept="image/x-icon,image/png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Logo Branca (Rodapé)</label>
                            <input type="file" name="logo_white" accept="image/png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descrição Curta (Rodapé)</label>
                            <textarea name="settings[company_description]" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('settings.company_description', $settings['company_description'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Copyright</label>
                            <input type="text" name="settings[copyright]"
                                value="{{ old('settings.copyright', $settings['copyright'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="© 2025 MIFIRE. Todos os direitos reservados.">
                        </div>
                    </div>
                </div>

                {{-- CONTATO --}}
                <div x-show="tab === 'contato'" class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">Dados de Contato</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">E-mail Principal</label>
                            <input type="email" name="settings[email]"
                                value="{{ old('settings.email', $settings['email'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telefone Principal</label>
                            <input type="text" name="settings[phone]"
                                value="{{ old('settings.phone', $settings['phone'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="(00) 0000-0000" data-mask="phone">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telefone Secundário</label>
                            <input type="text" name="settings[phone2]"
                                value="{{ old('settings.phone2', $settings['phone2'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="(00) 0000-0000" data-mask="phone">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                            <input type="text" name="settings[whatsapp]"
                                value="{{ old('settings.whatsapp', $settings['whatsapp'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="(00) 00000-0000" data-mask="phone">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Google Maps (URL Embed)</label>
                            <textarea name="settings[google_maps_embed]" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('settings.google_maps_embed', $settings['google_maps_embed'] ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- SOBRE --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">Sobre a Empresa</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Missão</label>
                            <textarea name="settings[mission]" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('settings.mission', $settings['mission'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Visão</label>
                            <textarea name="settings[vision]" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('settings.vision', $settings['vision'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Valores</label>
                            <textarea name="settings[values]" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('settings.values', $settings['values'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SEO --}}
                <div x-show="tab === 'seo'" class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">SEO</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Título (padrão)</label>
                            <input type="text" name="settings[meta_title]"
                                value="{{ old('settings.meta_title', $settings['meta_title'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Descrição (padrão)</label>
                            <textarea name="settings[meta_description]" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('settings.meta_description', $settings['meta_description'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords (padrão)</label>
                            <input type="text" name="settings[meta_keywords]"
                                value="{{ old('settings.meta_keywords', $settings['meta_keywords'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="palavra1, palavra2, palavra3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Google Analytics ID</label>
                            <input type="text" name="settings[google_analytics_id]"
                                value="{{ old('settings.google_analytics_id', $settings['google_analytics_id'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="G-XXXXXXXXXX">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Google Tag Manager ID</label>
                            <input type="text" name="settings[gtm_id]"
                                value="{{ old('settings.gtm_id', $settings['gtm_id'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="GTM-XXXXXXX">
                        </div>
                    </div>
                </div>

                {{-- PWA --}}
                <div x-show="tab === 'pwa'" class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">Progressive Web App
                        </h3>
                        
                        {{-- Ativar PWA Toggle --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Ativar PWA no Site</h4>
                                <p class="text-xs text-gray-500 mt-1">Habilita o aplicativo, cache offline e convite de instalação para os usuários.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="settings[pwa_enabled]" value="0">
                                <input type="checkbox" name="settings[pwa_enabled]" value="1" class="sr-only peer"
                                    {{ isset($settings['pwa_enabled']) && $settings['pwa_enabled'] ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome do App</label>
                            <input type="text" name="settings[pwa_name]"
                                value="{{ old('settings.pwa_name', $settings['pwa_name'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome Curto</label>
                            <input type="text" name="settings[pwa_short_name]"
                                value="{{ old('settings.pwa_short_name', $settings['pwa_short_name'] ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cor do Tema</label>
                            <input type="color" name="settings[theme_color]"
                                value="{{ old('settings.theme_color', $settings['theme_color'] ?? '#dc2626') }}"
                                class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cor de Fundo</label>
                            <input type="color" name="settings[background_color]"
                                value="{{ old('settings.background_color', $settings['background_color'] ?? '#ffffff') }}"
                                class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ícone 192x192</label>
                            <input type="file" name="pwa_icon_192" accept="image/png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ícone 512x512</label>
                            <input type="file" name="pwa_icon_512" accept="image/png"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
                        </div>
                    </div>
                </div>

                {{-- EMAIL --}}
                <div x-show="tab === 'email'" class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">Configuração de E-mail
                            (SMTP)</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Host SMTP</label>
                                <input type="text" name="settings[mail_host]"
                                    value="{{ old('settings.mail_host', $settings['mail_host'] ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    placeholder="smtp.gmail.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Porta</label>
                                <input type="number" name="settings[mail_port]"
                                    value="{{ old('settings.mail_port', $settings['mail_port'] ?? '587') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Usuário</label>
                                <input type="text" name="settings[mail_username]"
                                    value="{{ old('settings.mail_username', $settings['mail_username'] ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                                <input type="password" name="settings[mail_password]"
                                    value="{{ old('settings.mail_password', $settings['mail_password'] ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail Remetente</label>
                                <input type="email" name="settings[mail_from_address]"
                                    value="{{ old('settings.mail_from_address', $settings['mail_from_address'] ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nome Remetente</label>
                                <input type="text" name="settings[mail_from_name]"
                                    value="{{ old('settings.mail_from_name', $settings['mail_from_name'] ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Criptografia</label>
                            <select name="settings[mail_encryption]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="tls" {{ ($settings['mail_encryption'] ?? '') === 'tls' ? 'selected' : '' }}>TLS
                                </option>
                                <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL
                                </option>
                                <option value="" {{ empty($settings['mail_encryption'] ?? '') ? 'selected' : '' }}>Nenhuma
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- AVANÇADO --}}
                <div x-show="tab === 'avancado'" class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">Avançado</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Scripts no &lt;head&gt;</label>
                            <textarea name="settings[head_scripts]" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="<!-- Google Tag, pixels, etc. -->">{{ old('settings.head_scripts', $settings['head_scripts'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Scripts antes do
                                &lt;/body&gt;</label>
                            <textarea name="settings[body_scripts]" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="<!-- Chat widgets, analytics, etc. -->">{{ old('settings.body_scripts', $settings['body_scripts'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CSS Personalizado</label>
                            <textarea name="settings[custom_css]" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="/* Estilos personalizados */">{{ old('settings.custom_css', $settings['custom_css'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Modo de Manutenção</label>
                            <div
                                x-data="{ maintenance: {{ filter_var($settings['maintenance_mode'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false' }} }">
                                <button type="button" @click="maintenance = !maintenance"
                                    :class="maintenance ? 'bg-red-600' : 'bg-gray-300'"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                                    <span :class="maintenance ? 'translate-x-6' : 'translate-x-1'"
                                        class="inline-block h-4 w-4 transform bg-white rounded-full transition-transform"></span>
                                </button>
                                <input type="hidden" name="settings[maintenance_mode]" :value="maintenance ? '1' : '0'">
                                <span class="ml-3 text-sm font-medium text-gray-700"
                                    x-text="maintenance ? 'Ativado' : 'Desativado'"></span>
                            </div>
                        </div>

                        {{-- Configurações do Preloader --}}
                        <div class="pt-4 mt-6 border-t border-gray-100">
                            <h4 class="text-md font-semibold text-gray-900 mb-4">Tela de Carregamento (Preloader)</h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ativar Preloader</label>
                                    <div x-data="{ preloader: {{ filter_var($settings['preloader_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false' }} }">
                                        <button type="button" @click="preloader = !preloader"
                                            :class="preloader ? 'bg-red-600' : 'bg-gray-300'"
                                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                                            <span :class="preloader ? 'translate-x-6' : 'translate-x-1'"
                                                class="inline-block h-4 w-4 transform bg-white rounded-full transition-transform"></span>
                                        </button>
                                        <input type="hidden" name="settings[preloader_enabled]" :value="preloader ? '1' : '0'">
                                        <span class="ml-3 text-sm text-gray-600" x-text="preloader ? 'Ativado no Início do Site' : 'Desligado'"></span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cor de Fundo do Preloader</label>
                                    <input type="color" name="settings[preloader_bg_color]"
                                        value="{{ old('settings.preloader_bg_color', $settings['preloader_bg_color'] ?? '#ffffff') }}"
                                        class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo Animada (GIF, SVG ou PNG)</label>
                                    <input type="file" name="preloader_image" accept="image/png,image/gif,image/jpeg,image/svg+xml"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
                                    <p class="text-xs text-gray-500 mt-1">Deixe em branco para usar o site_logo cadastrado na aba "Geral".</p>
                                    @if(!empty($settings['preloader_image']))
                                        <div class="mt-2 bg-gray-100 w-fit p-3 rounded-lg border border-gray-200">
                                            <img src="{{ asset('storage/' . $settings['preloader_image']) }}" alt="Preloader Image" class="h-12 object-contain">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                        Salvar Configurações
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function settingsPage() {
                return { tab: '{{ request('tab', 'geral') }}' }
            }
        </script>
    @endpush
@endsection