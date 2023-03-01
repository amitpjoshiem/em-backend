<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post(
 *     path="/admins",
 *     tags={"User"},
 *     summary="Create Admin type Users",
 *     description="Create non client users for the Dashboard.",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email", "password", "password_confirmation"},
 *              @OA\Property (property="email", type="string", maxLength=255, format="email", example="test@test.com"),
 *              @OA\Property (property="password", type="string", maxLength=30, minLength=6, example="password"),
 *              @OA\Property (property="password_confirmation", type="string", maxLength=30, minLength=6, example="password"),
 *              @OA\Property (property="username", type="string", maxLength=100, minLength=2, example="Test"),
 *          ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Admin User",
 *         @OA\JsonContent(
 *             @OA\Schema(ref="#/components/schemas/User")
 *         ),
 *     ),
 * )
 */
Route::post('admins', [UserApiController::class, 'createAdmin'])
    ->name('api_user_create_admin')
    ->middleware(['auth:api']);
