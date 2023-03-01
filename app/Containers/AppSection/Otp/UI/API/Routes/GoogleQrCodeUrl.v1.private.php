<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/otps/google/qr",
 *     tags={"Otp"},
 *     summary="Otp",
 *     description="Get Google QR for Google 2FA",
 *     @OA\Response(
 *         response=200,
 *         description="Google QR link and Code for manual add 2FA",
 *         @OA\JsonContent(
 *             @OA\Property (property="code", type="string", example="Code for manual add Google 2FA"),
 *             @OA\Property (property="url", type="string", example="URL for generating QR COde for Google 2FA"),
 *         ),
 *     ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      )
 *  )
 */

use App\Containers\AppSection\Otp\UI\API\Controllers\Controller as OtpApiController;
use Illuminate\Support\Facades\Route;

Route::get('otps/google/qr', [OtpApiController::class, 'googleQr'])
    ->name('api_otp_google_qr')
    ->middleware(['auth:api']);
