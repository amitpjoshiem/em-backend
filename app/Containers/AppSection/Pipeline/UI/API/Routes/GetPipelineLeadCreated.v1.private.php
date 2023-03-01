<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/pipeline/lead/created",
 *     tags={"Pipeline"},
 *     summary="Lead Created",
 *     description="Statistics of Created Leads",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Leads Created Statistics",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="period", type="string", example="Jan"),
 *                  @OA\Property(property="count", type="int", example="4"),
 *              )
 *          ),
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      )
 *  )
 */

use App\Containers\AppSection\Pipeline\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('pipeline/lead/created', [Controller::class, 'GetCreatedLeads'])
    ->name('api_pipeline_lead_created')
    ->middleware(['auth:api', 'user_header']);
