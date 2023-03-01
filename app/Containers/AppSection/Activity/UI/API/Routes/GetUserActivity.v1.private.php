<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/activities",
 *     tags={"Activity"},
 *     summary="Get User Activity",
 *     description="Get All User Activity",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Activity",
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
 *                      property="activity",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected activity is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Activity\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('activities', [Controller::class, 'getUserActivities'])
    ->name('api_user_activity')
    ->middleware(['auth:api', 'user_header']);
