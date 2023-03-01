<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/tools/salesforce-import-status/data', [AdminWebController::class, 'salesforceImportStatusData'])
    ->name('web_admin_salesforce_import_status_data')
    ->middleware(['auth:web']);
