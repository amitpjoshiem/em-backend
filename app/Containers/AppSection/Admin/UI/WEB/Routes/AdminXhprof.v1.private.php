<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/tools/xhprof', [AdminWebController::class, 'xhprof'])
    ->name('web_admin_xhprof')
    ->middleware(['auth:web']);
