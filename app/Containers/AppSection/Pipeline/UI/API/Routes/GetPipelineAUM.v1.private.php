<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/pipeline/aum",
 *     tags={"Pipeline"},
 *     summary="AUM",
 *     description="Get Assets Under Managment For Pipeline",
 *      @OA\Response(
 *          response=200,
 *          description="Returned AUM",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="period", type="string", example="Jan"),
 *                  @OA\Property(property="amount", type="float", example="2745674.8159999996"),
 *              )
 *          ),
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      )
 *  )
 */

use App\Containers\AppSection\Pipeline\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('pipeline/aum', [Controller::class, 'getAUM'])
    ->name('api_pipeline_aum')
    ->middleware(['auth:api', 'user_header']);
