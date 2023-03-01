<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::post('admin/user/edit/{id}', [AdminWebController::class, 'submitEditUser'])
    ->name('web_admin_submit_user_edit')
    ->middleware(['auth:web']);
