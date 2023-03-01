<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::post('admin/user/register', [AdminWebController::class, 'submitRegisterUser'])
    ->name('web_admin_submit_user_register')
    ->middleware(['auth:web']);
