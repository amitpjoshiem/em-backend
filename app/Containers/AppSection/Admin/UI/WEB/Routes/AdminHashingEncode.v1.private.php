<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/tools/hashing/encode', [AdminWebController::class, 'hashingEncode'])
    ->name('web_admin_hashing_encode')
    ->middleware(['auth:web']);
