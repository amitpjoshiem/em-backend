<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get (
 *     path="/salesforce/opportunity/stages",
 *     tags={"Salesforce"},
 *     summary="Get Stages For Opportunity",
 *     description="Get Stages For Opportunity",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Status",
 *          @OA\JsonContent(
 *              @OA\Property (property="status", type="bool", example=false),
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
 *          ),
 *      ),
 *  )
 */
Route::get('/salesforce/opportunity/stages', [Controller::class, 'getOpportunityStages'])
    ->name('api_salesforce_get_opportunity_stages')
    ->middleware(['auth:api', 'user_header']);
