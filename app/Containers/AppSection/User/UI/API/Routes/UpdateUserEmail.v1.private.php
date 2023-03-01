<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Put (
 *     path="/email",
 *     tags={"User"},
 *     summary="User change email",
 *     description="Change user email and send verify message by token",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email"},
 *              @OA\Property (property="email", type="string", maxLength=255, format="email", example="test@test.com")
 *          )
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Return success message",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="Email verification link sent on your email."),
 *          ),
 *      ),
 * )
 */
Route::put('/email', [UserApiController::class, 'updateUserEmail'])
    ->name('api_update_user_email')
    ->middleware(['auth:api']);
