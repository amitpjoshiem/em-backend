<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/user/create-password/send/{id}', [AdminWebController::class, 'sendCreatePassword'])
    ->name('web_admin_send_create_password')
    ->middleware(['auth:web']);
