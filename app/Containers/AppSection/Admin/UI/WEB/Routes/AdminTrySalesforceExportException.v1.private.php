<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::post('admin/tools/salesforce/try/{export_exceptions_id}', [AdminWebController::class, 'tryExportException'])
    ->name('web_admin_try_export_exception')
    ->middleware(['auth:web']);
