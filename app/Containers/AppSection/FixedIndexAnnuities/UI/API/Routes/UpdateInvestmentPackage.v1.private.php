<?php

declare(strict_types=1);

/**
 * @OA\Patch (
 *     path="/investment_package/{id}",
 *     tags={"InvestmentPackeage"},
 *     summary="Create InvestmentPackeage",
 *     description="Create InvestmentPackeage",
 *      @OA\Response(
 *          response=204,
 *          description="Returned InvestmentPackeage",
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
 *                      property="fixedindexannuities",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected fixedindexannuities is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use OpenApi\Annotations as OA;

Route::patch('/investment_package/{id}', [Controller::class, 'updateInvestmentPackage'])
    ->name('api_fixedindexannuities_update_investment_package')
    ->middleware(['auth:api', 'user_header']);
