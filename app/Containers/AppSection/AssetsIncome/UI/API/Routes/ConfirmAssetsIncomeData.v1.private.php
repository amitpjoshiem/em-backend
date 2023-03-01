<?php

declare(strict_types=1);

use App\Containers\AppSection\AssetsIncome\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *     path="/assets_income/confirm/{member_id}",
 *     tags={"AssetsIncome"},
 *     summary="Confirm AssetsIncome Step",
 *     description="Confirm AssetsIncome Step",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\Response(
 *          response=204,
 *          description="Step Confirmed",
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
Route::post('assets_income/confirm/{member_id}', [Controller::class, 'confirmAssetsIncomeData'])
    ->name('api_assets_income_confirm')
    ->middleware(['auth:api', 'user_header', 'client_readonly']);
