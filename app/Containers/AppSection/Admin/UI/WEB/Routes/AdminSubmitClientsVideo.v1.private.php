<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::post('admin/client/videos/{type}', [AdminWebController::class, 'submitClientVideos'])
    ->name('web_admin_submit_client_videos')
    ->middleware(['auth:web']);
