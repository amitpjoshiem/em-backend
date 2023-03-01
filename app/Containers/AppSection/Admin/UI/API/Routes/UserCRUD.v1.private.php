<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])
    ->prefix('admin/users')
    ->name('api_admin_users_')
    ->group(function () {
        /**
         * @OA\Get (
         *     path="/admin/users",
         *     tags={"Admin"},
         *     summary="Admin Get Users",
         *     description="Admin Admin Get Users",
         *      @OA\Response(
         *          response=200,
         *          description="Return Users list",
         *          @OA\JsonContent(
         *              @OA\Property (
         *                  property="data",
         *                  type="array",
         *                  @OA\Items(ref="#/components/schemas/User")
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
        Route::get('', [Controller::class, 'getAllUsers'])
            ->name('get_all');
        /**
         * @OA\Get (
         *     path="/admin/users/find/{id}",
         *     tags={"Admin"},
         *     summary="Admin Get User By ID",
         *     description="Admin Get User By ID",
         *     @OA\Parameter(
         *          description="User ID",
         *          name="id",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="Hashed ID")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Return Users list",
         *          @OA\JsonContent(ref="#/components/schemas/User"),
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
        Route::get('find/{id}', [Controller::class, 'getUserById'])
            ->name('find_by_id');
        /**
         * @OA\Get (
         *     path="/admin/users/init",
         *     tags={"Admin"},
         *     summary="Admin Get Init For User Create",
         *     description="Admin Get Init For User Create",
         *      @OA\Response(
         *          response=200,
         *          description="Return Users list",
         *          @OA\JsonContent(
         *              @OA\Property(
         *                  property="data",
         *                  type="object",
         *                  @OA\Property(
         *                      property="roles",
         *                      type="array",
         *                      @OA\Items(ref="#/components/schemas/Role")
         *                  ),
         *                  @OA\Property(
         *                      property="companies",
         *                      type="array",
         *                      @OA\Items(ref="#/components/schemas/Company")
         *                  ),
         *              )
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
        Route::get('/init', [Controller::class, 'getInit'])
            ->name('get_init');
        /**
         * @OA\Post (
         *     path="/admin/users",
         *     tags={"Admin"},
         *     summary="Admin Create User",
         *     description="Admin Create User",
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Return Created User",
         *          @OA\JsonContent(ref="#/components/schemas/User")
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
        Route::post('', [Controller::class, 'createUser'])
            ->name('create_user');
        /**
         * @OA\Patch (
         *     path="/admin/users/{id}",
         *     tags={"Admin"},
         *     summary="Admin Update User",
         *     description="Admin Update User",
         *     @OA\Parameter(
         *          description="User ID",
         *          name="id",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="Hashed ID")
         *     ),
         *     @OA\RequestBody(
         *          required=false,
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Return Updated User",
         *          @OA\JsonContent(ref="#/components/schemas/User")
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
        Route::patch('/{id}', [Controller::class, 'updateUser'])
            ->name('update_user');
        /**
         * @OA\Delete (
         *     path="/admin/users/{id}",
         *     tags={"Admin"},
         *     summary="Admin Delete User",
         *     description="Admin Delete User",
         *     @OA\Parameter(
         *          description="User ID",
         *          name="id",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="Hashed ID")
         *     ),
         *     @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(
         *              @OA\Property (
         *                  property="transfer_to",
         *                  type="string",
         *                  example="bpy390dg3jova6gm"
         *              ),
         *          ),
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
        Route::delete('/{id}', [Controller::class, 'deleteUser'])
            ->name('delete_user');
        /**
         * @OA\Post (
         *     path="/admin/users/restore/{id}",
         *     tags={"Admin"},
         *     summary="Admin Restore User",
         *     description="Admin Restore User",
         *     @OA\Parameter(
         *          description="User ID",
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
        Route::post('restore/{id}', [Controller::class, 'restoreUser'])
            ->name('restore_user');
        /**
         * @OA\Post (
         *     path="/admin/users/send/{id}",
         *     tags={"Admin"},
         *     summary="Admin Send Create Password",
         *     description="Admin Send Create Password",
         *     @OA\Parameter(
         *          description="User ID",
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
        Route::post('/send/{id}', [Controller::class, 'sendCreatePassword'])
            ->name('send_create_password');
        /**
         * @OA\Get (
         *     path="/admin/users/advisors/{company_id}",
         *     tags={"Admin"},
         *     summary="Admin Get Advisors By Company",
         *     description="Admin Get Advisors By Company",
         *     @OA\Parameter(
         *          description="Company ID",
         *          name="company_id",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="Hashed ID")
         *     ),
         *      @OA\Response(
         *          response=200,
         *          description="Return Advisors list",
         *          @OA\JsonContent(
         *              @OA\Property (
         *                  property="data",
         *                  type="array",
         *                  @OA\Items(ref="#/components/schemas/User")
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
        Route::get('/advisors/{company_id}', [Controller::class, 'getCompanyAdvisors'])
            ->name('get_company_advisors');
    });
