<?php

declare(strict_types=1);

/**
 * @OA\GET (
 *     path="/monthly_expenses/{member_id}",
 *     tags={"MonthlyExpense"},
 *     summary="Get MonthlyExpense",
 *     description="Get MonthlyExpense",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
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

Route::get('monthly_expenses/{member_id}', [Controller::class, 'getMonthlyExpenses'])
    ->name('api_monthly_expense_get_monthly_expenses')
    ->middleware(['auth:api', 'user_header', 'terms_and_conditions']);
