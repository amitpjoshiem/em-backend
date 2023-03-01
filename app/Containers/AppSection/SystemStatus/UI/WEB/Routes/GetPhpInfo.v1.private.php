<?php

declare(strict_types=1);

use App\Containers\AppSection\SystemStatus\UI\WEB\Controllers\Controller as StatusWebController;
use Illuminate\Support\Facades\Route;

Route::get('/phpinfo', [StatusWebController::class, 'getPhpInfo'])
    ->name('api_ping_get_phpinfo');
