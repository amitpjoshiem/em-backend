<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/user/edit/{id}', [AdminWebController::class, 'editUser'])
    ->name('web_admin_edit_user')
    ->middleware(['auth:web']);
