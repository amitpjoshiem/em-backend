<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'user_header'])
    ->prefix('salesforce/child_opportunity')
    ->name('api_salesforce_child_opportunity_')
    ->group(function () {
        /**
         * @OA\GET (
         *     path="/salesforce/child_opportunity/find/{child_opportunity_id}",
         *     tags={"Salesforce Child Opportunity"},
         *     summary="Get Child Opportunity",
         *     description="Get Child Opportunity By ID",
         *     @OA\Parameter(
         *          description="Child Opportunity Hashed ID",
         *          name="child_opportunity_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Child Opportunity",
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
        Route::get('/find/{child_opportunity_id}', [Controller::class, 'getChildOpportunityById'])
            ->name('find');

        /**
         * @OA\GET (
         *     path="/salesforce/child_opportunity/all/{member_id}",
         *     tags={"Salesforce Child Opportunity"},
         *     summary="Get All Child Opportunities",
         *     description="Get All Child Opportunities By Member ID",
         *     @OA\Parameter(
         *          description="Member Hashed ID",
         *          name="member_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Child Opportunity",
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
        Route::get('/all/{member_id}', [Controller::class, 'getAllMembersChildOpportunities'])
            ->name('all');

        /**
         * @OA\POST (
         *     path="/salesforce/child_opportunity",
         *     tags={"Salesforce Child Opportunity"},
         *     summary="Create Child Opportunity",
         *     description="Create Child Opportunity",
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(
         *              required={"member_id", "stage", "close_date", "type", "amount"},
         *              @OA\Property (property="member_id", type="string", example="bpy390dg3jova6gm"),
         *              @OA\Property (property="stage", type="string", example="Exampler Stage Name"),
         *              @OA\Property (property="close_date", type="date", example="1970-01-01"),
         *              @OA\Property (property="type", type="date", example="Exampler Type Name"),
         *              @OA\Property (property="amount", type="date", example="999999"),
         *          ),
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Child Opportunity",
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
        Route::post('', [Controller::class, 'createChildOpportunity'])
            ->name('create');

        /**
         * @OA\PATCH (
         *     path="/salesforce/child_opportunity/{child_opportunity_id}",
         *     tags={"Salesforce Child Opportunity"},
         *     summary="Update Child Opportunity",
         *     description="Update Child Opportunity",
         *     @OA\Parameter(
         *          description="Child Opportunity Hashed ID",
         *          name="child_opportunity_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(
         *              @OA\Property (property="stage", type="string", example="Exampler Stage Name"),
         *              @OA\Property (property="close_date", type="date", example="1970-01-01"),
         *              @OA\Property (property="type", type="date", example="Exampler Type Name"),
         *              @OA\Property (property="amount", type="date", example="999999"),
         *          ),
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Child Opportunity",
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
        Route::patch('/{id}', [Controller::class, 'updateChildOpportunity'])
            ->name('update');

        /**
         * @OA\DELETE (
         *     path="/salesforce/child_opportunity/{child_opportunity_id}",
         *     tags={"Salesforce Child Opportunity"},
         *     summary="Delete Child Opportunity",
         *     description="Delete Child Opportunity In Salesforce",
         *     @OA\Parameter(
         *          description="Child Opportunity Hashed ID",
         *          name="child_opportunity_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=204,
         *          description="Delete Successfull",
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
        Route::delete('/{id}', [Controller::class, 'deleteChildOpportunity'])
            ->name('delete');

        /**
         * @OA\GET (
         *     path="/salesforce/child_opportunity_id/init",
         *     tags={"Salesforce Child Opportunity"},
         *     summary="Get Child Opportunity Init List",
         *     description="Get Child Opportunity Init List With Stage And Type List",
         *      @OA\Response(
         *          response=200,
         *          description="Returned Init List",
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
        Route::get('/init', [Controller::class, 'childOpportunityInit'])
            ->name('init');
    });
