<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/tools/hashing/decode', [AdminWebController::class, 'hashingDecode'])
    ->name('web_admin_hashing_decode')
    ->middleware(['auth:web']);
