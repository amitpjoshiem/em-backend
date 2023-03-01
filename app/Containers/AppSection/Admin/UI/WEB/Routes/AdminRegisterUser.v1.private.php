<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/user/register', [AdminWebController::class, 'registerUser'])
    ->name('web_admin_register_user')
    ->middleware(['auth:web']);
