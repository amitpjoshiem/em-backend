<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/pipeline/member/statistics/age",
 *     tags={"Pipeline"},
 *     summary="Member Age",
 *     description="Get Member Age Statistics For Pipeline",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Member Age Statistics",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="start_age", type="int", example="30"),
 *                  @OA\Property(property="end_age", type="int", example="39"),
 *                  @OA\Property(property="precent", type="float", example="18.8159999996"),
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

Route::get('pipeline/member/statistics/age', [Controller::class, 'getMemberAge'])
    ->name('api_pipeline_member_age')
    ->middleware(['auth:api', 'user_header']);
