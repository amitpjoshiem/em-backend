<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post(
 *     path="users/phone/send_verify",
 *     tags={"User"},
 *     summary="Send Verify SMS Code",
 *     description="",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"phone"},
 *              @OA\Property (property="phone", type="string", example="+123456789"),
 *          ),
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Successfully Sended"
 *     ),
 * )
 */
Route::post('users/phone/send_verify', [UserApiController::class, 'sendVerifyPhone'])
    ->name('api_user_send_verify_phone')
    ->middleware(['auth:api']);
