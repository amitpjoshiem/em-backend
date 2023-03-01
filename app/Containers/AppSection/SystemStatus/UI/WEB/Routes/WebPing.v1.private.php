<?php

declare(strict_types=1);

use App\Containers\AppSection\SystemStatus\UI\WEB\Controllers\Controller as StatusWebController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', [StatusWebController::class, 'ping'])
    ->name('web_ping');
