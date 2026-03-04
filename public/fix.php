<?php

use Illuminate\Support\Facades\Artisan;

/**
 * Script de Emergência para MiFire CMS
 * Este arquivo deve ser colocado na pasta /public do seu servidor
 */

// Se o arquivo estiver sendo acessado diretamente no public/
// Precisamos carregar o bootstrap do Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h1>MiFire - Ferramenta de Reparo</h1>";

try {
    echo "1. Tentando criar link simbólico...<br>";
    Artisan::call('storage:link');
    echo "✅ Link simbólico processado (Artisan).<br><br>";
} catch (\Exception $e) {
    echo "❌ Erro Artisan storage:link: " . $e->getMessage() . "<br><br>";
}

try {
    echo "2. Limpando caches de rotas e configurações...<br>";
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    echo "✅ Caches limpos com sucesso.<br><br>";
} catch (\Exception $e) {
    echo "❌ Erro ao limpar caches: " . $e->getMessage() . "<br><br>";
}

echo "<hr>";
echo "<strong>Tente acessar o site agora e verifique se as imagens aparecem.</strong><br>";
echo "<em>Remova este arquivo (fix.php) do servidor após o uso por segurança.</em>";
