<?php

declare(strict_types=1);

/**
 * @OA\GET (
 *     path="/logs",
 *     tags={"EntityLogs"},
 *     summary="EntityLogs",
 *     description="EntityLogsr",
 *      @OA\Response(
 *          response=200,
 *          description="Returned EntityLogger",
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
 *                      property="entitylogger",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected entitylogger is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\EntityLogger\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('logs', [Controller::class, 'getAllEntityLoggers'])
    ->name('api_entitylogger_get_all_entity_logs')
    ->middleware(['auth:api']);
