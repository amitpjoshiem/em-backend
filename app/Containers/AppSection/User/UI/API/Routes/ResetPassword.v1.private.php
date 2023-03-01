<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *     path="/password/reset",
 *     tags={"User"},
 *     summary="Resets a password for an user.",
 *     description="Reset password by token email and passwords",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"token", "email", "password", "password_confirmation"},
 *              @OA\Property (property="token", type="string", example="d0be2dc421be4fcd0172e5afceea3970e2f3d940"),
 *              @OA\Property (property="email", type="string", maxLength=255, format="email", example="test@test.com"),
 *              @OA\Property (property="password", type="string", maxLength=30, minLength=6, example="password"),
 *              @OA\Property (property="password_confirmation", type="string", maxLength=30, minLength=6, example="password"),
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Return status of password reset",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string")
 *          ),
 *     ),
 * )
 */
Route::post('password/reset', [UserApiController::class, 'resetPassword'])
    ->name('api_user_reset_password');
