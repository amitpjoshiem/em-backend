<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/pipeline/member/statistics/count",
 *     tags={"Pipeline"},
 *     summary="Member Count",
 *     description="Get Member Count Statistics For Pipeline",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Member Count Statistics",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="period", type="string", example="Jan"),
 *                  @OA\Property(property="count", type="int", example="16"),
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

Route::get('pipeline/member/statistics/count', [Controller::class, 'getMemberCount'])
    ->name('api_pipeline_member_count')
    ->middleware(['auth:api', 'user_header']);
