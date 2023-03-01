<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/companies', [AdminWebController::class, 'companies'])
    ->name('web_admin_companies')
    ->middleware(['auth:web']);
