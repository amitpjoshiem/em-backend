<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'user_header'])
    ->prefix('salesforce/account')
    ->name('api_salesforce_account_')
    ->group(function () {
        /**
         * @OA\GET (
         *     path="/salesforce/account/{member_id}",
         *     tags={"Salesforce Accounts"},
         *     summary="Get Account",
         *     description="Get Account By Member Info",
         *     @OA\Parameter(
         *          description="Member Hashed ID",
         *          name="member_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Account",
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
        Route::get('/{member_id}', [Controller::class, 'getAccountByMemberId'])
            ->name('find');

        /**
         * @OA\POST (
         *     path="/salesforce/account",
         *     tags={"Salesforce Accounts"},
         *     summary="Create Account",
         *     description="Create Account By Member Info",
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(
         *              required={"member_id"},
         *              @OA\Property (property="member_id", type="string", example="bpy390dg3jova6gm"),
         *          ),
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Account",
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
        Route::post('', [Controller::class, 'createAccount'])
            ->name('create');

        /**
         * @OA\PATCH (
         *     path="/salesforce/account/{member_id}",
         *     tags={"Salesforce Accounts"},
         *     summary="Update Account",
         *     description="Update Account By Member Info",
         *     @OA\Parameter(
         *          description="Member Hashed ID",
         *          name="member_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Account",
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
        Route::patch('/{member_id}', [Controller::class, 'updateAccount'])
            ->name('update');

        /**
         * @OA\DELETE (
         *     path="/salesforce/account/{member_id}",
         *     tags={"Salesforce Accounts"},
         *     summary="Delete Account",
         *     description="Delete Account In Salesforce",
         *     @OA\Parameter(
         *          description="Member Hashed ID",
         *          name="member_id",
         *          in="path",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Returned Account",
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
        Route::delete('/{member_id}', [Controller::class, 'deleteAccount'])
            ->name('delete');
    });
