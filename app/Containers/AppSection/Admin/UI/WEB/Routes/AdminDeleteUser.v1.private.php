<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/user/delete/{id}', [AdminWebController::class, 'deleteUser'])
    ->name('web_admin_delete_user')
    ->middleware(['auth:web']);
