<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/users', [AdminWebController::class, 'users'])
    ->name('web_admin_users')
    ->middleware(['auth:web']);
