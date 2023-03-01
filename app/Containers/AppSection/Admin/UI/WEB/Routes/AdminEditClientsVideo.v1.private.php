<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/client/videos/{type}', [AdminWebController::class, 'editClientVideos'])
    ->name('web_admin_edit_client_videos')
    ->middleware(['auth:web']);
