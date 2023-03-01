<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Patch (
 *     path="/salesforce/opportunity/stage/{member_id}",
 *     tags={"Salesforce"},
 *     summary="Update Salesfroce",
 *     description="Get Info about Salesforce Member Status",
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
Route::patch('/salesforce/opportunity/stage/{member_id}', [Controller::class, 'updateOpportunityStage'])
    ->name('api_salesforce_update_opportunity_stage')
    ->middleware(['auth:api', 'user_header']);
