<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/dashboard/pipeline",
 *     tags={"Dashboard"},
 *     summary="PipeLine",
 *     description="Get PipeLine info For Dashboard",
 *     @OA\Parameter(
 *          description="Type of Period",
 *          name="type",
 *          in="query",
 *          required=true,
 *          @OA\Examples(example="string", value="year", summary="year|quarter|month")
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Returned PipeLine",
 *          @OA\JsonContent(
 *              @OA\Property(property="members", type="integer", example="77"),
 *              @OA\Property(property="new_members", type="integer", example="33"),
 *              @OA\Property(property="aum", type="float", example="6942399680.942"),
 *              @OA\Property(property="new_aum", type="float", example="5827472569.925")
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
 *                      property="type",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected type is invalid.")
 *                  )
 *              ),
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
use App\Containers\AppSection\Dashboard\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('dashboard/pipeline', [Controller::class, 'dashboardPipeLine'])
    ->name('api_dashboard_pipeline')
    ->middleware(['auth:api', 'user_header']);
