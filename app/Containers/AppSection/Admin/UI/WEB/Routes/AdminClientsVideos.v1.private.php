<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\WEB\Controllers\Controller as AdminWebController;
use Illuminate\Support\Facades\Route;

Route::get('admin/client/videos', [AdminWebController::class, 'clientVideos'])
    ->name('web_admin_client_videos')
    ->middleware(['auth:web']);
