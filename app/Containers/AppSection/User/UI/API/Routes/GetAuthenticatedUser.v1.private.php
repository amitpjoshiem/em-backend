<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *     path="/users/profile",
 *     tags={"User"},
 *     summary="profile",
 *     description="Get user profile info",
 *     @OA\Response(
 *         response=200,
 *         description="test",
 *         @OA\JsonContent(
 *             @OA\Schema(ref="#/components/schemas/User")
 *         ),
 *     ),
 * )
 */
Route::get('users/profile', [UserApiController::class, 'getAuthenticatedUser'])
    ->name('api_user_get_authenticated_user')
    ->middleware(['auth:api']);
