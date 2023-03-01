<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::post('admin/company/register', [AdminWebController::class, 'submitRegisterCompany'])
    ->name('web_admin_submit_company_register')
    ->middleware(['auth:web']);
