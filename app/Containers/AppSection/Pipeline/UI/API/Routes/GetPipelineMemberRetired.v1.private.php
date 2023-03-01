<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/pipeline/member/statistics/retired",
 *     tags={"Pipeline"},
 *     summary="Memer Retired",
 *     description="Get Member Retired Statistics For Pipeline",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Member Retired Statistics",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="period", type="string", example="Jan"),
 *                  @OA\Property(property="retired", type="int", example="4"),
 *                  @OA\Property(property="employers", type="int", example="6"),
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

Route::get('pipeline/member/statistics/retired', [Controller::class, 'getMemberRetired'])
    ->name('api_pipeline_member_retired')
    ->middleware(['auth:api', 'user_header']);
