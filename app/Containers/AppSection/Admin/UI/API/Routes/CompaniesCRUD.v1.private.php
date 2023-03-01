<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])
    ->prefix('admin/companies')
    ->name('api_admin_companies_')
    ->group(function () {
        /**
         * @OA\Get (
         *     path="/admin/companies",
         *     tags={"Admin"},
         *     summary="Admin Get Companies",
         *     description="Admin Get Companies",
         *      @OA\Response(
         *          response=200,
         *          description="Return Companies list",
         *          @OA\JsonContent(
         *              @OA\Property (
         *                  property="data",
         *                  type="array",
         *                  @OA\Items(ref="#/components/schemas/Company")
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
         *  )
         */
        Route::get('', [Controller::class, 'getAllCompanies'])
            ->name('get_all');
        /**
         * @OA\Get (
         *     path="/admin/companies/find/{id}",
         *     tags={"Admin"},
         *     summary="Admin Get Company By ID",
         *     description="Admin Get Company By ID",
         *     @OA\Parameter(
         *          description="Company ID",
         *          name="id",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="Hashed ID")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Return Company",
         *          @OA\JsonContent(ref="#/components/schemas/Company"),
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *          @OA\JsonContent(
         *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
         *          ),
         *      ),
         *  )
         */
        Route::get('find/{id}', [Controller::class, 'getCompanyById'])
            ->name('find_by_id');
        /**
         * @OA\Post (
         *     path="/admin/companies",
         *     tags={"Admin"},
         *     summary="Admin Create Company",
         *     description="Admin Create Company",
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/Company")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Return Created Company",
         *          @OA\JsonContent(ref="#/components/schemas/Company")
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *          @OA\JsonContent(
         *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
         *          ),
         *      ),
         *  )
         */
        Route::post('', [Controller::class, 'createCompany'])
            ->name('create');
        /**
         * @OA\Patch (
         *     path="/admin/companies/{id}",
         *     tags={"Admin"},
         *     summary="Admin Update Company",
         *     description="Admin Update Company",
         *     @OA\Parameter(
         *          description="Company ID",
         *          name="id",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="Hashed ID")
         *     ),
         *     @OA\RequestBody(
         *          required=false,
         *          @OA\JsonContent(ref="#/components/schemas/Company")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Return Updated User",
         *          @OA\JsonContent(ref="#/components/schemas/Company")
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *          @OA\JsonContent(
         *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
         *          ),
         *      ),
         *  )
         */
        Route::patch('/{id}', [Controller::class, 'updateCompany'])
            ->name('update');
        /**
         * @OA\Delete (
         *     path="/admin/companies/{id}",
         *     tags={"Admin"},
         *     summary="Admin Delete Company",
         *     description="Admin Delete Company",
         *     @OA\Parameter(
         *          description="Company ID",
         *          name="id",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="Hashed ID")
         *     ),
         *      @OA\Response(
         *          response=204,
         *          description="Success",
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *          @OA\JsonContent(
         *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
         *          ),
         *      ),
         *  )
         */
        Route::delete('/{id}', [Controller::class, 'deleteCompany'])
            ->name('delete');
    });
