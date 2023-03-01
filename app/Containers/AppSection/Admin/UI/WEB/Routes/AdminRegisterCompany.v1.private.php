<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/companies/register', [AdminWebController::class, 'registerCompany'])
    ->name('web_admin_register_company')
    ->middleware(['auth:web']);
