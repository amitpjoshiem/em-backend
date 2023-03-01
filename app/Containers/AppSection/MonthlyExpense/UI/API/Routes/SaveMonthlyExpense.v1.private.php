<?php

declare(strict_types=1);

/**
 * @OA\POST (
 *     path="/monthly_expenses/{member_id}",
 *     tags={"MonthlyExpense"},
 *     summary="Save MonthlyExpense",
 *     description="Save MonthlyExpense",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/MonthlyExpense")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned MonthlyExpense",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="data",
 *                  type="object",
 *                  ref="#/components/schemas/MonthlyExpense"
 *              ),
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
 *                      property="monthlyexpense",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected monthlyexpense is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\MonthlyExpense\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('monthly_expenses/{member_id}', [Controller::class, 'saveMonthlyExpense'])
    ->name('api_monthly_expense_create_monthly_expense')
    ->middleware(['auth:api', 'user_header', 'client_readonly']);
