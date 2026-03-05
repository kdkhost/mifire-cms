<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

// 1. Verificar configurações do WhatsApp widget no banco
echo "=== WHATSAPP WIDGET SETTINGS NO BANCO ===\n";
$keys = [
    'whatsapp_widget_title',
    'whatsapp_widget_attendants',
    'whatsapp_bg_color',
    'whatsapp_text_color',
    'whatsapp_position',
    'whatsapp_animation',
];

foreach ($keys as $key) {
    $val = Setting::get($key, 'NÃO ENCONTRADO');
    echo "$key: " . substr($val, 0, 300) . "\n";
}

// 2. Verificar se há arquivos no storage/whatsapp_attendants
echo "\n=== ARQUIVOS NO STORAGE ===\n";
$files = Storage::disk('public')->files('whatsapp_attendants');
if (empty($files)) {
    echo "Nenhum arquivo encontrado em storage/app/public/whatsapp_attendants\n";
} else {
    foreach ($files as $f) {
        echo "- $f\n";
    }
}

// 3. Verificar se o symlink do storage está correto
echo "\n=== STORAGE LINK ===\n";
$publicPath = public_path('storage');
if (is_link($publicPath)) {
    echo "Symlink OK: $publicPath -> " . readlink($publicPath) . "\n";
} else {
    echo "PROBLEMA: Symlink NÃO existe em public/storage!\n";
    echo "Execute: php artisan storage:link\n";
}

echo "\nDone.\n";
