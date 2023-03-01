<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/dashboard/opportunity",
 *     tags={"Dashboard"},
 *     summary="Opportunity",
 *     description="Get Opportunity info For Dashboard",
 *     @OA\Parameter(
 *          description="Type of Period",
 *          name="type",
 *          in="query",
 *          required=true,
 *          @OA\Examples(example="string", value="year", summary="year|quarter|month")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Opportunity List Groped By Period",
 *          @OA\JsonContent(
 *              @OA\Property(property="total", type="float", example="22698561.63300001"),
 *              @OA\Property(property="percent", type="float", example="100"),
 *              @OA\Property(property="up", type="boolean", example="true"),
 *              @OA\Property (
 *                  property="values",
 *                  type="array",
 *                  @OA\Items(
 *                      @OA\Property(property="period", type="string", example="Jan"),
 *                      @OA\Property(property="amount", type="float", example="2745674.8159999996"),
 *                  )
 *              ),
 *          ),
 *      ),
 *     @OA\Response(
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

Route::get('dashboard/opportunity', [Controller::class, 'dashboardOpportunity'])
    ->name('api_dashboard_opportunity')
    ->middleware(['auth:api', 'user_header']);
