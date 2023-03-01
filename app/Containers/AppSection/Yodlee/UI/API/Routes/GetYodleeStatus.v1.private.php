<?php

declare(strict_types=1);

use App\Containers\AppSection\Yodlee\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get (
 *     path="/yodlee/{member_id}/status",
 *     tags={"Yodlee"},
 *     summary="Status",
 *     description="Get Member Yodlee Status",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Status",
 *          @OA\JsonContent(
 *              @OA\Property (property="yodlee_created", type="bool", example="true"),
 *              @OA\Property (property="link_sent", type="bool", example="true"),
 *              @OA\Property (property="link_used", type="bool", example="true"),
 *              @OA\Property (property="provider_count", type="int", example="11"),
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
 *              ),
 *          ),
 *      ),
 *  )
 */
Route::get('yodlee/{member_id}/status', [Controller::class, 'getYodleeStatus'])
    ->name('api_yodlee_get_status')
    ->middleware(['auth:api', 'user_header']);
