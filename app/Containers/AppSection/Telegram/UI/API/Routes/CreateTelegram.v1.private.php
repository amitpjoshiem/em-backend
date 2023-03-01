<?php

declare(strict_types=1);

/**
 * @OA\POST (
 *     path="/telegram/login",
 *     tags={"Telegram"},
 *     summary="Telegram Login",
 *     description="Telegram Login",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"telegram"},
 *              @OA\Property (property="telegram", type="string", example="Telegram"),
 *          ),
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Telegram",
 *          @OA\JsonContent(
 *              @OA\Property (property="telegram", type="string", example="Telegram"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Unprocessable Entity",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="The given data was invalid."),
 *              @OA\Property (
 *                  property="errors",
 *                  type="object",
 *                  @OA\Property(
 *                      property="telegram",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected telegram is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Telegram\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('telegram/login', [Controller::class, 'loginTelegram'])
    ->name('api_telegram_login_telegram')
    ->middleware(['auth:api']);
