<?php

declare(strict_types=1);

use App\Containers\AppSection\AssetsIncome\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post(
 *     path="/assets_income/row/{member_id}",
 *     tags={"AssetsIncome"},
 *     summary="Get Assets Income Data",
 *     description="Get Assets Income Data",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"group, row"},
 *              @OA\Property (property="group", description="One of the 3 types current_income|liquid_assets|other_assets_investments", type="string", example="liquid_assets"),
 *              @OA\Property (property="row", description="Name of Row", type="string", example="row"),
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Returned Data",
 *          @OA\JsonContent(ref="#/components/schemas/AssetsIncome"),
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
 *                      property="assetsconsolidations",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected assetsconsolidations is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */
Route::post('assets_income/row/{member_id}', [Controller::class, 'createAssetsIncomeRow'])
    ->name('api_assets_income_create_row')
    ->middleware(['auth:api', 'user_header', 'client_readonly']);
