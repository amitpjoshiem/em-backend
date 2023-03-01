<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *     path="/lead/create-password/send",
 *     tags={"User"},
 *     summary="ReSend create password link for an lead.",
 *     description="ReSend create password link for an lead.",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email"},
 *              @OA\Property (property="email", type="string", maxLength=255, format="email", example="test@test.com"),
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
Route::post('lead/create-password/send', [UserApiController::class, 'reSendLeadCreatePassword'])
    ->name('lead_send_create_password')
    ->middleware(['auth:api']);
