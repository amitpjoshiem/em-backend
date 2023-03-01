<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post(
 *     path="users/phone/verify",
 *     tags={"User"},
 *     summary="Verify SMS Code",
 *     description="",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"phone"},
 *              @OA\Property (property="code", type="string", example="999999"),
 *          ),
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Successfully Verified"
 *     ),
 * )
 */
Route::post('users/phone/verify', [UserApiController::class, 'verifyPhone'])
    ->name('api_user_verify_phone')
    ->middleware(['auth:api']);
