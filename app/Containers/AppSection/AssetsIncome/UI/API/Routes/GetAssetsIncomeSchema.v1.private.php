<?php

declare(strict_types=1);

use App\Containers\AppSection\AssetsIncome\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get (
 *     path="/assets_income/schema/{member_id}",
 *     tags={"AssetsIncome"},
 *     summary="Get Assets Income Schema",
 *     description="Get Assets Income Schema",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Returned Schema",
 *          @OA\JsonContent(
 *              @OA\Property(property="title", type="string", example="Current Income"),
 *              @OA\Property(property="name", type="string", example="current_income"),
 *              @OA\Property(property="headers", type="array", @OA\Items(type="string", example="owner")),
 *              @OA\Property(
 *                  property="rows",
 *                  type="array",
 *                  @OA\Items(
 *                      @OA\Property(property="label", type="string", example="Income Plan"),
 *                      @OA\Property(property="name", type="string", example="income_plan"),
 *                      @OA\Property(property="custom", type="bool", example="true"),
 *                      @OA\Property(
 *                          property="elements",
 *                          type="array",
 *                          @OA\Items(
 *                               @OA\Property(property="type", type="string", example="radio"),
 *                               @OA\Property(property="name", type="string", example="income_plan"),
 *                               @OA\Property(property="label", type="string", example="Income Plan"),
 *                               @OA\Property(property="disabled", type="bool", example="false"),
 *                               @OA\Property(
 *                                  property="model",
 *                                  type="array",
 *                                  @OA\Items(
 *                                      @OA\Property(property="group", type="string", example="current_income"),
 *                                      @OA\Property(property="model", type="string", example="income_plan"),
 *                                      @OA\Property(property="item", type="string", example="income_plan"),
 *                                  )
 *                               ),
 *                          )
 *                      ),
 *                  )
 *             )
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
Route::get('assets_income/schema/{member_id}', [Controller::class, 'getAssetsIncomeSchema'])
    ->name('api_assets_income_get_schema')
    ->middleware(['auth:api', 'user_header', 'terms_and_conditions']);
