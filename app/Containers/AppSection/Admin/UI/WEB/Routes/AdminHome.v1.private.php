<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', [AdminWebController::class, 'home'])
    ->name('web_admin_home')
    ->middleware(['auth:web']);

Route::redirect('', '/admin');
