<?php

declare(strict_types=1);

/**
 * @OA\Post (
 *     path="/investment_package/sign/{id}",
 *     tags={"InvestmentPackeage"},
 *     summary="Sign InvestmentPackeage",
 *     description="Sign InvestmentPackeage",
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

Route::post('/investment_package/sign/{id}', [Controller::class, 'signInvestmentPackage'])
    ->name('api_fixedindexannuities_sign_investment_package')
    ->middleware(['auth:api', 'user_header']);
