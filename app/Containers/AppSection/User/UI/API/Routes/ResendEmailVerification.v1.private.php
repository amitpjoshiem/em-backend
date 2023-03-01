<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get (
 *     path="/email/resend",
 *     tags={"User"},
 *     summary="User resend email",
 *     description="User resend email verification",
 *     @OA\RequestBody(
 *          @OA\JsonContent(
 *              @OA\Property (property="email", type="string", maxLength=255, format="email", example="test@test.com"),
 *          ),
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Email verification link sent success.",
 *      ),
 * )
 */
Route::get('email/resend', [UserApiController::class, 'resendEmailVerification'])
    ->name('verification.resend')
    ->middleware(['auth:api', 'throttle:6,1']);
