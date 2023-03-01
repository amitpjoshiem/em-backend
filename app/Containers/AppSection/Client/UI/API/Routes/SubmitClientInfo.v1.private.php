<?php

declare(strict_types=1);

/**
 * @OA\Post (
 *     path="/clients/submit",
 *     tags={"Client"},
 *     summary="Submit Client Info",
 *     description="Submit Client Info",
 *      @OA\Response(
 *          response=204,
 *          description="Confirmed",
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
 *                      property="assetsconsolidations",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected assetsconsolidations is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Client\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('clients/submit/', [Controller::class, 'submitClientInfo'])
    ->name('api_client_submit_client_info')
    ->middleware(['auth:api', 'user_header', 'client_readonly']);
