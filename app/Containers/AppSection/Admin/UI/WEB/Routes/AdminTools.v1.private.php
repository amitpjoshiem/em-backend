<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/tools', [AdminWebController::class, 'adminTools'])
    ->name('web_admin_tools')
    ->middleware(['auth:web']);
