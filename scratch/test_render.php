<?php

use App\Http\Controllers\Admin\PortalManagerController;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    $controller = app(PortalManagerController::class);
    $request = Request::create('/admin/portal-manager', 'GET');
    $response = $controller->index($request);
    $html = $response->render();
    file_put_contents(__DIR__.'/rendered.html', $html);
    echo 'SUCCESS: '.strlen($html)." bytes\n";
} catch (Throwable $e) {
    echo 'ERROR: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine()."\n";
    echo $e->getTraceAsString();
}
