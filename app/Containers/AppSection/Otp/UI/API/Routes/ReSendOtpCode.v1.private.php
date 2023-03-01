<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/otps/resend",
 *     tags={"Otp"},
 *     summary="Otp",
 *     description="Resend Otp Code",
 *      @OA\Response(
 *          response=204,
 *          description="Code Successfuly Resended",
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Otp\UI\API\Controllers\Controller as OtpApiController;
use Illuminate\Support\Facades\Route;

Route::get('otps/resend', [OtpApiController::class, 'reSendOtp'])
    ->name('api_otp_resend_code')
    ->middleware(['auth:api']);
