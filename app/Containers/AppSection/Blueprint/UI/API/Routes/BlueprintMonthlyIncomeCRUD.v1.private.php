<?php

declare(strict_types=1);

use App\Containers\AppSection\Blueprint\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'user_header'])
    ->prefix('blueprint/monthly_income')
    ->name('api_blueprint_monthly_income_')
    ->group(function () {
        /**
         * @OA\POST (
         *     path="/blueprint/monthly_income/{member_id}",
         *     tags={"BluePrint"},
         *     summary="Save Monthly Income",
         *     description="Save Monthly Income Data",
         *     @OA\Parameter(
         *          description="Member ID",
         *          name="id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/BlueprintMonthlyIncome")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Concern",
         *          @OA\JsonContent(ref="#/components/schemas/BlueprintMonthlyIncome"),
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
         *                      property="member",
         *                      type="array",
         *                      @OA\Items(type="string", example="The selected member is invalid.")
         *                  )
         *              ),
         *          ),
         *      ),
         *  )
         */
        Route::post('/{member_id}', [Controller::class, 'saveBlueprintMonthlyIncome'])
            ->name('save');
        /**
         * @OA\Get (
         *     path="/blueprint/monthly_income/{member_id}",
         *     tags={"BluePrint"},
         *     summary="Get Monthly Income",
         *     description="Get Monthly Income Data",
         *     @OA\Parameter(
         *          description="Member ID",
         *          name="id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Monthly Income",
         *          @OA\JsonContent(ref="#/components/schemas/BlueprintMonthlyIncome"),
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
         *                      property="member",
         *                      type="array",
         *                      @OA\Items(type="string", example="The selected member is invalid.")
         *                  )
         *              ),
         *          ),
         *      ),
         *  )
         */
        Route::get('/{member_id}', [Controller::class, 'getBlueprintMonthlyIncome'])
            ->name('get');
    });
