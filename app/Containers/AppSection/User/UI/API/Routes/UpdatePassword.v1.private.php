<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Put (
 *     path="/password",
 *     tags={"User"},
 *     summary="Update Password",
 *     description="Change user password",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"current_password", "password", "password_confirmation"},
 *              @OA\Property (property="current_password", type="string", maxLength=30, minLength=6, example="current_password"),
 *              @OA\Property (property="password", type="string", maxLength=30, minLength=6, example="password"),
 *              @OA\Property (property="password_confirmation", type="string", maxLength=30, minLength=6, example="password"),
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Return success message",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="Password successfully changed."),
 *          ),
 *      ),
 * )
 */
Route::put('/password', [UserApiController::class, 'updatePassword'])
    ->name('api_user_update_password')
    ->middleware(['auth:api']);
