<?php

declare(strict_types=1);

use App\Containers\AppSection\SystemStatus\UI\API\Controllers\Controller as SystemStatusApiController;
use Illuminate\Support\Facades\Route;

/**
 * {GET} /v1/{any?} Fallback Route Not Found.
 */
Route::fallback([SystemStatusApiController::class, 'fallbackRouteNotFound'])
    ->name('api_fallback_404')
    ->middleware(['throttle:6,1']);
