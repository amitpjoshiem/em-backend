<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::post('admin/company/edit/{id}', [AdminWebController::class, 'submitEditCompany'])
    ->name('web_admin_submit_company_edit')
    ->middleware(['auth:web']);
