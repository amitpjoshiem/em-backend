<?php

declare(strict_types=1);

use App\Containers\AppSection\Member\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'user_header'])
    ->prefix('asset_allocation/{member_id}')
    ->name('api_asset_allocation_')
    ->group(function () {
        /**
         * @OA\POST (
         *     path="/asset_allocation/{member_id}",
         *     tags={"Asset Allocation"},
         *     summary="Save Member Asset Allocation",
         *     description="Save Member Asset Allocation Data",
         *     @OA\Parameter(
         *          description="Member ID",
         *          name="member_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/MemberAssetAllocation")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Concern",
         *          @OA\JsonContent(ref="#/components/schemas/MemberAssetAllocation"),
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
        Route::post('/', [Controller::class, 'saveAssetAllocation'])
            ->name('save');
        /**
         * @OA\Get (
         *     path="/asset_allocation/{member_id}",
         *     tags={"Asset Allocation"},
         *     summary="Get Member Asset Allocation",
         *     description="Get Member Asset Allocation Data",
         *     @OA\Parameter(
         *          description="Member ID",
         *          name="member_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Monthly Income",
         *          @OA\JsonContent(ref="#/components/schemas/MemberAssetAllocation"),
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
        Route::get('/', [Controller::class, 'getAssetAllocation'])
            ->name('get');
    });
