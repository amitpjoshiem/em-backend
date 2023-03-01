<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/tools/salesforce-api-status', [AdminWebController::class, 'salesforceApiStatus'])
    ->name('web_admin_salesforce_api_status')
    ->middleware(['auth:web']);
