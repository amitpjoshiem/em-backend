<?php

declare(strict_types=1);

/**
 * @OA\POST (
 *     path="/otps/verify",
 *     tags={"Otp"},
 *     summary="Otp",
 *     description="Verify Otp Code in Login",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"code"},
 *              @OA\Property (property="code", type="string", example="123456"),
 *          ),
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Success Code Verify",
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Invalid Code",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="Invalid Code")
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Otp\UI\API\Controllers\Controller as OtpApiController;
use Illuminate\Support\Facades\Route;

Route::post('otps/verify', [OtpApiController::class, 'verifyOtp'])
    ->name('api_otp_verify_otp')
    ->middleware(['auth:api']);
