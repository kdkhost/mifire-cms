<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\EmailTemplate;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    /**
     * Check if the application is already installed.
     */
    public static function isInstalled(): bool
    {
        return File::exists(storage_path('installed'));
    }

    // ── Step 1: Requirements ──────────────────────────────

    public function requirements()
    {
        $requirements = $this->checkRequirements();
        $allPassed = collect($requirements)->every(fn($r) => $r['passed']);

        return view('install.requirements', compact('requirements', 'allPassed'));
    }

    // ── Step 2: Permissions ───────────────────────────────

    public function permissions()
    {
        $permissions = $this->checkPermissions();
        $allPassed = collect($permissions)->every(fn($p) => $p['passed']);

        return view('install.permissions', compact('permissions', 'allPassed'));
    }

    // ── Step 3: Database ──────────────────────────────────

    public function database()
    {
        $db = session('install_db', [
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', ''),
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
        ]);

        return view('install.database', compact('db'));
    }

    public function saveDatabase(Request $request)
    {
        $validated = $request->validate([
            'host' => 'required|string|max:255',
            'port' => 'required|string|max:10',
            'database' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
        ]);

        // Test connection
        $connectionError = $this->testDatabaseConnection($validated);

        if ($connectionError) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Falha na conexão com o banco de dados: ' . $connectionError]);
        }

        session(['install_db' => $validated]);

        return redirect()->route('install.admin');
    }

    // ── Step 4: Admin User ────────────────────────────────

    public function admin()
    {
        $admin = session('install_admin', [
            'name' => '',
            'email' => '',
        ]);

        return view('install.admin', compact('admin'));
    }

    public function saveAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        session(['install_admin' => $validated]);

        return redirect()->route('install.settings');
    }

    // ── Step 5: Site Settings ─────────────────────────────

    public function settings()
    {
        $settings = session('install_settings', [
            'site_name' => 'MiFire',
            'site_description' => 'Soluções em Prevenção e Combate a Incêndio',
            'admin_email' => session('install_admin.email', 'comercial@mat-eng.com.br'),
        ]);

        return view('install.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'admin_email' => 'required|email|max:255',
        ]);

        session(['install_settings' => $validated]);

        return redirect()->route('install.run');
    }

    // ── Step 6: Run Installation ──────────────────────────

    public function run()
    {
        $db = session('install_db');
        $admin = session('install_admin');
        $settings = session('install_settings');

        if (!$db || !$admin || !$settings) {
            return redirect()->route('install.database')
                ->withErrors(['install' => 'Dados de instalação incompletos. Por favor, preencha todos os passos.']);
        }

        return view('install.installing', compact('db', 'admin', 'settings'));
    }

    public function execute()
    {
        $db = session('install_db');
        $admin = session('install_admin');
        $settings = session('install_settings');

        if (!$db || !$admin || !$settings) {
            return response()->json([
                'success' => false,
                'message' => 'Dados de instalação incompletos.',
            ], 422);
        }

        try {
            // 1. Update .env file with database settings
            $this->updateEnvFile([
                'DB_CONNECTION' => 'mariadb',
                'DB_HOST' => $db['host'],
                'DB_PORT' => $db['port'],
                'DB_DATABASE' => $db['database'],
                'DB_USERNAME' => $db['username'],
                'DB_PASSWORD' => $db['password'],
                'APP_NAME' => '"' . $settings['site_name'] . '"',
                'MAIL_FROM_ADDRESS' => '"' . $settings['admin_email'] . '"',
                'MAIL_FROM_NAME' => '"' . $settings['site_name'] . '"',
            ]);

            // 2. Reload database configuration (MariaDB)
            config([
                'database.connections.mariadb.host' => $db['host'],
                'database.connections.mariadb.port' => $db['port'],
                'database.connections.mariadb.database' => $db['database'],
                'database.connections.mariadb.username' => $db['username'],
                'database.connections.mariadb.password' => $db['password'] ?? '',
            ]);

            DB::purge('mariadb');
            DB::reconnect('mariadb');

            // 3. Run migrations
            Artisan::call('migrate', ['--force' => true]);

            // 4. Run seeders
            Artisan::call('db:seed', ['--force' => true]);

            // 5. Create admin user
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make($admin['password']),
                    'is_admin' => true,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            // 6. Update site settings
            Setting::set('site_name', $settings['site_name'], 'general', 'text');
            Setting::set('site_description', $settings['site_description'], 'general', 'textarea');
            Setting::set('site_email', $settings['admin_email'], 'general', 'email');

            // 7. Create storage link
            Artisan::call('storage:link', ['--force' => true]);

            // 8. Clear caches
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');

            // 9. Mark as installed
            File::put(storage_path('installed'), now()->toDateTimeString());

            // 10. Clear install session data
            session()->forget(['install_db', 'install_admin', 'install_settings']);

            return response()->json([
                'success' => true,
                'message' => 'Instalação concluída com sucesso!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro durante a instalação: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ── Step 7: Complete ──────────────────────────────────

    public function complete()
    {
        return view('install.complete');
    }

    // ── Helper Methods ────────────────────────────────────

    private function checkRequirements(): array
    {
        return [
            [
                'name' => 'Versão do PHP (>= 8.4)',
                'passed' => version_compare(PHP_VERSION, '8.4.0', '>='),
                'current' => PHP_VERSION,
            ],
            [
                'name' => 'Extensão PDO',
                'passed' => extension_loaded('pdo'),
                'current' => extension_loaded('pdo') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão Mbstring',
                'passed' => extension_loaded('mbstring'),
                'current' => extension_loaded('mbstring') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão OpenSSL',
                'passed' => extension_loaded('openssl'),
                'current' => extension_loaded('openssl') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão Tokenizer',
                'passed' => extension_loaded('tokenizer'),
                'current' => extension_loaded('tokenizer') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão XML',
                'passed' => extension_loaded('xml'),
                'current' => extension_loaded('xml') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão Ctype',
                'passed' => extension_loaded('ctype'),
                'current' => extension_loaded('ctype') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão JSON',
                'passed' => extension_loaded('json'),
                'current' => extension_loaded('json') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão BCMath',
                'passed' => extension_loaded('bcmath'),
                'current' => extension_loaded('bcmath') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão Fileinfo',
                'passed' => extension_loaded('fileinfo'),
                'current' => extension_loaded('fileinfo') ? 'Instalada' : 'Não encontrada',
            ],
            [
                'name' => 'Extensão GD',
                'passed' => extension_loaded('gd'),
                'current' => extension_loaded('gd') ? 'Instalada' : 'Não encontrada',
            ],
        ];
    }

    private function checkPermissions(): array
    {
        return [
            [
                'name' => 'storage/',
                'path' => storage_path(),
                'passed' => is_writable(storage_path()),
                'current' => $this->getPermissionString(storage_path()),
            ],
            [
                'name' => 'storage/app/',
                'path' => storage_path('app'),
                'passed' => is_writable(storage_path('app')),
                'current' => $this->getPermissionString(storage_path('app')),
            ],
            [
                'name' => 'storage/framework/',
                'path' => storage_path('framework'),
                'passed' => is_writable(storage_path('framework')),
                'current' => $this->getPermissionString(storage_path('framework')),
            ],
            [
                'name' => 'storage/logs/',
                'path' => storage_path('logs'),
                'passed' => is_writable(storage_path('logs')),
                'current' => $this->getPermissionString(storage_path('logs')),
            ],
            [
                'name' => 'bootstrap/cache/',
                'path' => base_path('bootstrap/cache'),
                'passed' => is_writable(base_path('bootstrap/cache')),
                'current' => $this->getPermissionString(base_path('bootstrap/cache')),
            ],
            [
                'name' => '.env',
                'path' => base_path('.env'),
                'passed' => File::exists(base_path('.env')) && is_writable(base_path('.env')),
                'current' => File::exists(base_path('.env'))
                    ? $this->getPermissionString(base_path('.env'))
                    : 'Arquivo não encontrado',
            ],
        ];
    }

    private function getPermissionString(string $path): string
    {
        if (!File::exists($path)) {
            return 'Não encontrado';
        }

        return substr(sprintf('%o', fileperms($path)), -4);
    }

    private function testDatabaseConnection(array $config): ?string
    {
        try {
            $pdo = new \PDO(
                "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset=utf8mb4",
                $config['username'],
                $config['password'] ?? '',
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_TIMEOUT => 5,
                ]
            );
            $pdo = null;
            return null;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    private function updateEnvFile(array $values): void
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            // Copy from .env.example if .env doesn't exist
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), $envPath);
            } else {
                File::put($envPath, '');
            }
        }

        $content = File::get($envPath);

        foreach ($values as $key => $value) {
            $pattern = "/^{$key}=.*/m";

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, "{$key}={$value}", $content);
            } else {
                $content .= "\n{$key}={$value}";
            }
        }

        File::put($envPath, $content);
    }
}
