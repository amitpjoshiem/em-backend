<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/companies/edit/{id}', [AdminWebController::class, 'editCompany'])
    ->name('web_admin_edit_company')
    ->middleware(['auth:web']);
