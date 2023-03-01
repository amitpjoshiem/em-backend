<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'user_header'])
    ->prefix('salesforce/annual_review')
    ->name('api_salesforce_annual_review_')
    ->group(function () {
        /**
         * @OA\GET (
         *     path="/salesforce/annual_review/{id}",
         *     tags={"Salesforce Annual Review"},
         *     summary="Get Annual Review",
         *     description="Get Annual Review By ID",
         *     @OA\Parameter(
         *          description="Annual Review ID",
         *          name="id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Annual Review",
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
        Route::get('/find/{id}', [Controller::class, 'getAnnualReviewById'])
            ->name('find');

        /**
         * @OA\Get (
         *     path="/salesforce/annual_review/all/{member_id}",
         *     tags={"Salesforce Annual Review"},
         *     summary="Get All Annual Review",
         *     description="Get All Annual Review By Member ID",
         *     @OA\Parameter(
         *          description="Member ID",
         *          name="member_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Annual Reviews",
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
        Route::get('/all/{member_id}', [Controller::class, 'getAllAnnualReviews'])
            ->name('get_all');

        /**
         * @OA\Post (
         *     path="/salesforce/annual_review/{member_id}",
         *     tags={"Salesforce Annual Review"},
         *     summary="Create Annual Review",
         *     description="Create Annual Review For Member",
         *     @OA\Parameter(
         *          description="Member Hashed ID",
         *          name="member_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Annual Review",
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
        Route::post('/{member_id}', [Controller::class, 'createAnnualReview'])
            ->name('create');

        /**
         * @OA\Patch (
         *     path="/salesforce/annual_review/{id}",
         *     tags={"Salesforce Annual Review"},
         *     summary="Update Annual Review",
         *     description="Update Annual Review",
         *     @OA\Parameter(
         *          description="Annual Review ID",
         *          name="id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Annual Review",
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
        Route::patch('/{id}', [Controller::class, 'updateAnnualReview'])
            ->name('update');

        /**
         * @OA\DELETE (
         *     path="/salesforce/annual_review/{id}",
         *     tags={"Salesforce Annual Review"},
         *     summary="Delete Annual Review",
         *     description="Delete Annual Review In Salesforce",
         *     @OA\Parameter(
         *          description="Annual Review ID",
         *          name="id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=204,
         *          description="Deleted",
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
        Route::delete('/{id}', [Controller::class, 'deleteAnnualReview'])
            ->name('delete');
    });
