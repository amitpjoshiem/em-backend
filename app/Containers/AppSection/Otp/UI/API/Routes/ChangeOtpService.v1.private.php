<?php

declare(strict_types=1);

/**
 * @OA\POST (
 *     path="/otps/change",
 *     tags={"Otp"},
 *     summary="Otp",
 *     description="Change Otp Service Type",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"service"},
 *              @OA\Property (property="service", description="One of the 3 types email|google|phone", type="string", example="google"),
 *              @OA\Property (property="code", description="If select Google 2FA need code for verify", type="string", example="123456"),
 *          ),
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Success Change Service Type",
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

Route::post('otps/change', [OtpApiController::class, 'changeOtp'])
    ->name('api_otp_change_otp')
    ->middleware(['auth:api']);
