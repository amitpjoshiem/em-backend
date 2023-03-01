<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *     path="/password/forgot",
 *     tags={"User"},
 *     summary="User forgot password",
 *     description="Send user by email to reset password",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email"},
 *              @OA\Property (property="email", type="string", example="test@test.com")
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Return status of password forgot",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string")
 *          ),
 *     ),
 * )
 */
Route::post('password/forgot', [UserApiController::class, 'sendForgotPassword'])
    ->name('api_user_forgot_password');
