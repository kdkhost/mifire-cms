<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\EmailTemplate;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedSettings();
        $this->seedEmailTemplates();
        $this->seedProductCategories();
        $this->seedBlogCategories();
        $this->seedDownloadCategories();
        $this->seedAddresses();
        $this->seedSocialLinks();
        $this->seedMenus();
    }

    // ── Settings ──────────────────────────────────────────

    private function seedSettings(): void
    {
        $settings = [
            // General
            ['group' => 'general', 'key' => 'site_name', 'value' => 'MiFire', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'Soluções em Prevenção e Combate a Incêndio', 'type' => 'textarea'],
            ['group' => 'general', 'key' => 'site_email', 'value' => 'comercial@mat-eng.com.br', 'type' => 'email'],
            ['group' => 'general', 'key' => 'site_phone', 'value' => '(21) 2111-4151', 'type' => 'text'],
            ['group' => 'general', 'key' => 'footer_text', 'value' => 'MiFire - Soluções em Prevenção e Combate a Incêndio', 'type' => 'textarea'],
            ['group' => 'general', 'key' => 'copyright', 'value' => '© ' . date('Y') . ' MiFire. Todos os direitos reservados.', 'type' => 'text'],
            ['group' => 'general', 'key' => 'contact_email', 'value' => 'comercial@mat-eng.com.br', 'type' => 'email'],

            // PWA
            ['group' => 'pwa', 'key' => 'pwa_enabled', 'value' => '1', 'type' => 'boolean'],
            ['group' => 'pwa', 'key' => 'pwa_name', 'value' => 'MiFire', 'type' => 'text'],
            ['group' => 'pwa', 'key' => 'pwa_short_name', 'value' => 'MiFire', 'type' => 'text'],
            ['group' => 'pwa', 'key' => 'pwa_theme_color', 'value' => '#dc2626', 'type' => 'color'],
            ['group' => 'pwa', 'key' => 'pwa_background_color', 'value' => '#ffffff', 'type' => 'color'],

            // Analytics
            ['group' => 'analytics', 'key' => 'analytics_enabled', 'value' => '0', 'type' => 'boolean'],

            // Social
            ['group' => 'social', 'key' => 'social_facebook', 'value' => 'https://www.facebook.com/miaborr', 'type' => 'url'],
            ['group' => 'social', 'key' => 'social_linkedin', 'value' => 'https://www.linkedin.com/company/mifire', 'type' => 'url'],
            ['group' => 'social', 'key' => 'social_instagram', 'value' => 'https://www.instagram.com/mifire_oficial', 'type' => 'url'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    // ── Email Templates ───────────────────────────────────

    private function seedEmailTemplates(): void
    {
        $templates = [
            [
                'name' => 'Contato Recebido',
                'slug' => 'contact_received',
                'subject' => 'Novo contato recebido - {{name}}',
                'body' => '<h2>Novo contato recebido</h2>'
                    . '<p><strong>Nome:</strong> {{name}}</p>'
                    . '<p><strong>Email:</strong> {{email}}</p>'
                    . '<p><strong>Telefone:</strong> {{phone}}</p>'
                    . '<p><strong>Assunto:</strong> {{subject}}</p>'
                    . '<p><strong>Mensagem:</strong></p>'
                    . '<p>{{message}}</p>',
                'variables' => ['name', 'email', 'phone', 'subject', 'message'],
                'is_active' => true,
            ],
            [
                'name' => 'Resposta de Contato',
                'slug' => 'contact_reply',
                'subject' => 'Re: {{subject}} - MiFire',
                'body' => '<h2>Olá {{name}},</h2>'
                    . '<p>Obrigado por entrar em contato conosco.</p>'
                    . '<p>{{reply}}</p>'
                    . '<br>'
                    . '<p>Atenciosamente,<br>Equipe MiFire</p>',
                'variables' => ['name', 'subject', 'reply'],
                'is_active' => true,
            ],
            [
                'name' => 'Bem-vindo',
                'slug' => 'welcome',
                'subject' => 'Bem-vindo à MiFire, {{name}}!',
                'body' => '<h2>Bem-vindo, {{name}}!</h2>'
                    . '<p>Sua conta foi criada com sucesso na plataforma MiFire.</p>'
                    . '<p>Acesse o sistema através do link: <a href="{{login_url}}">{{login_url}}</a></p>'
                    . '<br>'
                    . '<p>Atenciosamente,<br>Equipe MiFire</p>',
                'variables' => ['name', 'login_url'],
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }

    // ── Product Categories ────────────────────────────────

    private function seedProductCategories(): void
    {
        $categories = ['Extintores', 'Detecção e Alarme', 'Sistemas de Combate'];

        foreach ($categories as $i => $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name), 'type' => 'product'],
                [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'type' => 'product',
                    'is_active' => true,
                    'sort_order' => $i,
                ]
            );
        }
    }

    // ── Blog Categories ───────────────────────────────────

    private function seedBlogCategories(): void
    {
        $categories = ['Extintores', 'Prevenção e Combate', 'Mi Fire', 'Sistemas', 'Detecção de Incêndio'];

        foreach ($categories as $i => $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name) . '-blog', 'type' => 'blog'],
                [
                    'name' => $name,
                    'slug' => Str::slug($name) . '-blog',
                    'type' => 'blog',
                    'is_active' => true,
                    'sort_order' => $i,
                ]
            );
        }
    }

    // ── Download Categories ───────────────────────────────

    private function seedDownloadCategories(): void
    {
        $categories = ['Manuais', 'Ficha de Emergência', 'Política de Qualidade', 'Certificados'];

        foreach ($categories as $i => $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name) . '-download', 'type' => 'download'],
                [
                    'name' => $name,
                    'slug' => Str::slug($name) . '-download',
                    'type' => 'download',
                    'is_active' => true,
                    'sort_order' => $i,
                ]
            );
        }
    }

    // ── Addresses ─────────────────────────────────────────

    private function seedAddresses(): void
    {
        $addresses = [
            [
                'label' => 'Matriz RJ',
                'address' => 'Av. João Cabral de Mello Neto, 850',
                'complement' => null,
                'city' => 'Barra da Tijuca',
                'state' => 'RJ',
                'zip_code' => '22775-057',
                'phone' => '55 21 2111-4151',
                'phone2' => null,
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'label' => 'Filial/Fábrica SP',
                'address' => 'Av. Tenente Marques, 4906',
                'complement' => null,
                'city' => 'Santana de Parnaíba',
                'state' => 'SP',
                'zip_code' => '06530-001',
                'phone' => '55 11 2450-6878',
                'phone2' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
        ];

        foreach ($addresses as $address) {
            Address::updateOrCreate(
                ['label' => $address['label']],
                $address
            );
        }
    }

    // ── Social Links ──────────────────────────────────────

    private function seedSocialLinks(): void
    {
        $links = [
            [
                'platform' => 'Facebook',
                'url' => 'https://www.facebook.com/miaborr',
                'icon' => 'fab fa-facebook-f',
                'is_active' => true,
                'sort_order' => 0,
            ],
            [
                'platform' => 'LinkedIn',
                'url' => 'https://www.linkedin.com/company/mifire',
                'icon' => 'fab fa-linkedin-in',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'platform' => 'Instagram',
                'url' => 'https://www.instagram.com/mifire_oficial',
                'icon' => 'fab fa-instagram',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($links as $link) {
            SocialLink::updateOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }

    // ── Menus ─────────────────────────────────────────────

    private function seedMenus(): void
    {
        $items = [
            ['title' => 'Home', 'url' => '/', 'sort_order' => 0],
            ['title' => 'Sobre Nós', 'url' => '/sobre', 'sort_order' => 1],
            ['title' => 'Dry-Flo', 'url' => '/dry-flo', 'sort_order' => 2],
            ['title' => 'Notifier', 'url' => '/notifier', 'sort_order' => 3],
            ['title' => 'Extintores', 'url' => '/extintores', 'sort_order' => 4],
            ['title' => 'Novec', 'url' => '/novec', 'sort_order' => 5],
            ['title' => 'Sistemas', 'url' => '/sistemas', 'sort_order' => 6],
            ['title' => 'Blog', 'url' => '/blog', 'sort_order' => 7],
            ['title' => 'Downloads', 'url' => '/downloads', 'sort_order' => 8],
            ['title' => 'Contato', 'url' => '/contato', 'sort_order' => 9],
        ];

        foreach ($items as $item) {
            Menu::updateOrCreate(
                ['title' => $item['title'], 'location' => 'main'],
                array_merge($item, [
                    'location' => 'main',
                    'target' => '_self',
                    'is_active' => true,
                ])
            );
        }
    }
}
