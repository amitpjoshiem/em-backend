<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/user/{id}', [AdminWebController::class, 'userPage'])
    ->name('web_admin_user_page')
    ->middleware(['auth:web']);
