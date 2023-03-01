<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/pipeline/closed_win_lost",
 *     tags={"Pipeline"},
 *     summary="Closed Win vs Lost",
 *     description="Statistics of Closed Win vs Closed Lost",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Closed Win vs Closed Lost Statistics",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="period", type="string", example="Jan"),
 *                  @OA\Property(property="win", type="int", example="4"),
 *                  @OA\Property(property="lost", type="int", example="3"),
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

Route::get('pipeline/closed_win_lost', [Controller::class, 'GetClosedWinLost'])
    ->name('api_pipeline_closed_win_lost')
    ->middleware(['auth:api', 'user_header']);
