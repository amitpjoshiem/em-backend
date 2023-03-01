<?php

declare(strict_types=1);

/**
 * @OA\GET (
 *     path="/partners/healthcheck",
 *     tags={"HealthCheck"},
 *     summary="Get Partners Healthcheck",
 *     description="Get Partners Healthcheck",
 *      @OA\Response(
 *          response=200,
 *          description="Return Partners Healthcheck",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="salesforce",
 *                  type="bool",
 *                  example=true
 *              ),
 *              @OA\Property (
 *                  property="yodlee",
 *                  type="bool",
 *                  example=true
 *              ),
 *              @OA\Property (
 *                  property="hiddenlevers",
 *                  type="bool",
 *                  example=true
 *              )
 *          ),
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

use App\Containers\AppSection\SystemStatus\UI\API\Controllers\Controller as StatusApiController;
use Illuminate\Support\Facades\Route;

Route::get('/partners/healthcheck', [StatusApiController::class, 'getPartnersHealthcheck'])
    ->name('api_partners_healthcheck')
    ->middleware('auth:api');
