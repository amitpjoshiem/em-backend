<?php

declare(strict_types=1);

use App\Containers\AppSection\Blueprint\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'user_header'])
    ->prefix('blueprint/networth')
    ->name('api_blueprint_networth_')
    ->group(function () {
        /**
         * @OA\POST (
         *     path="/blueprint/networth/{member_id}",
         *     tags={"BluePrint"},
         *     summary="Save Net Worth",
         *     description="Save Net Worth Data",
         *     @OA\Parameter(
         *          description="Member ID",
         *          name="id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/BlueprintNetworth")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Concern",
         *          @OA\JsonContent(ref="#/components/schemas/BlueprintNetworth"),
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
        Route::post('/{member_id}', [Controller::class, 'saveBlueprintNetWorth'])
            ->name('save');

        /**
         * @OA\Get (
         *     path="/blueprint/networth/{member_id}",
         *     tags={"BluePrint"},
         *     summary="Get Net Worth",
         *     description="Get Net Worth Data",
         *     @OA\Parameter(
         *          description="Member ID",
         *          name="id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Concern",
         *          @OA\JsonContent(ref="#/components/schemas/BlueprintNetworth"),
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
        Route::get('/{member_id}', [Controller::class, 'getBlueprintNetWorth'])
            ->name('get');
    });
