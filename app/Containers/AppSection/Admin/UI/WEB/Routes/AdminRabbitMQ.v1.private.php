<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/tools/rabbitmq', [AdminWebController::class, 'rabbitmq'])
    ->name('web_admin_rabbitmq')
    ->middleware(['auth:web']);
