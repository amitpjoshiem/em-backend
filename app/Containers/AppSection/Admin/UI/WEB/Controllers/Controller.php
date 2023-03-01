<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\WEB\Controllers;

use App\Containers\AppSection\Admin\Actions\AdminEditCompanyAction;
use App\Containers\AppSection\Admin\Actions\AdminEditUserAction;
use App\Containers\AppSection\Admin\Actions\AdminRegisterCompanyAction;
use App\Containers\AppSection\Admin\Actions\AdminRegisterUserAction;
use App\Containers\AppSection\Admin\Actions\FindUserAction;
use App\Containers\AppSection\Admin\Actions\GetAllAdvisorsSubAction;
use App\Containers\AppSection\Admin\Actions\GetAllClientHelpAction;
use App\Containers\AppSection\Admin\Actions\GetClientHelpAction;
use App\Containers\AppSection\Admin\Actions\SendCreatePasswordAction;
use App\Containers\AppSection\Admin\Actions\TryExportExceptionAction;
use App\Containers\AppSection\Admin\Data\Transporters\HashingDecodeTransporter;
use App\Containers\AppSection\Admin\UI\WEB\Requests\AdminHomeRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\AdminUsersRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\EditClientVideoPageRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\EditCompanyPageRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\EditCompanyRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\EditUserPageRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\EditUserRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\HashingDecodeRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\HashingEncodeRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\RegisterCompanyRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\RegisterUserPageRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\RegisterUserRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\SendCreatePasswordRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\SubmitClientVideoRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\TryExportExceptionRequest;
use App\Containers\AppSection\Admin\UI\WEB\Requests\UserPageRequest;
use App\Containers\AppSection\Authorization\Actions\GetAllRolesAction;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\FindAllSalesforceImportsTask;
use App\Containers\AppSection\Salesforce\Tasks\GetAllSalesforceExportExceptionsTasks;
use App\Containers\AppSection\Salesforce\Tasks\GetAllSalesforceImportExceptionsTasks;
use App\Containers\AppSection\Salesforce\UI\API\Transformers\SalesforceImportsTransformer;
use App\Containers\AppSection\User\Actions\DeleteUserAction;
use App\Containers\AppSection\User\Actions\GetAllCompaniesAction;
use App\Containers\AppSection\User\Actions\GetAllUsersAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindCompanyByIdTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tasks\GetAllCompaniesTask;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserRequest;
use App\Ship\Parents\Controllers\WebController;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class Controller extends WebController
{
    public function home(AdminHomeRequest $request): View
    {
        return view('appSection@admin::home');
    }

    public function users(AdminUsersRequest $request): View
    {
        $users = app(GetAllUsersAction::class)->run(true, true);

        return view('appSection@admin::users', ['users' => $users]);
    }

    public function registerUser(RegisterUserPageRequest $request): View
    {
        /** @var Collection $roles */
        $roles = app(GetAllRolesAction::class)->run();
        /** @var Collection $companies */
        $companies = app(GetAllCompaniesTask::class)->run();
        /** @var Collection $advisors */
        $advisors = app(GetAllAdvisorsSubAction::class)->run();

        return view('appSection@admin::register_user', [
            'roles'         => $roles->toArray(),
            'companies'     => $companies->toArray(),
            'advisorsList'  => $advisors->toArray(),
        ]);
    }

    public function submitRegisterUser(RegisterUserRequest $request): Redirector | Application | RedirectResponse
    {
        app(AdminRegisterUserAction::class)->run($request->toTransporter());

        return redirect(route('web_admin_users'));
    }

    public function deleteUser(DeleteUserRequest $request): Redirector | Application | RedirectResponse
    {
        app(DeleteUserAction::class)->run($request);

        return redirect(route('web_admin_users'));
    }

    public function editUser(EditUserPageRequest $request): View
    {
        /** @var User $user */
        $user  = app(FindUserByIdTask::class)->withRelations(['roles', 'advisors'])->run($request->id);

        /** @var Collection $roles */
        $roles = app(GetAllRolesAction::class)->run();
        /** @var Collection $companies */
        $companies = app(GetAllCompaniesTask::class)->run();

        /** @var Collection $advisors */
        $advisors = app(GetAllAdvisorsSubAction::class)->run();

        return view('appSection@admin::edit_user', [
            'user'          => $user,
            'roles'         => $roles->toArray(),
            'companies'     => $companies->toArray(),
            'advisors'      => $user->advisors->pluck('id')->toArray(),
            'advisorsList'  => $advisors->toArray(),
        ]);
    }

    public function submitEditUser(EditUserRequest $request): Redirector | Application | RedirectResponse
    {
        app(AdminEditUserAction::class)->run($request->toTransporter());

        return redirect(route('web_admin_users'));
    }

    public function sendCreatePassword(SendCreatePasswordRequest $request): Redirector|Application|RedirectResponse
    {
        app(SendCreatePasswordAction::class)->run($request->toTransporter());

        return redirect(route('web_admin_users'));
    }

    public function companies(): View
    {
        $companies = app(GetAllCompaniesAction::class)->run();

        return view('appSection@admin::companies ', ['companies' => $companies]);
    }

    public function registerCompany(): View
    {
        return view('appSection@admin::register_company');
    }

    public function submitRegisterCompany(RegisterCompanyRequest $request): Redirector | Application | RedirectResponse
    {
        app(AdminRegisterCompanyAction::class)->run($request->toTransporter());

        return redirect(route('web_admin_companies'));
    }

    public function editCompany(EditCompanyPageRequest $request): View
    {
        $company = app(FindCompanyByIdTask::class)->run($request->id);

        return view('appSection@admin::edit_company', [
            'company' => $company,
        ]);
    }

    public function submitEditCompany(EditCompanyRequest $request): Redirector | Application | RedirectResponse
    {
        app(AdminEditCompanyAction::class)->run($request->toTransporter());

        return redirect(route('web_admin_companies'));
    }

    public function userPage(UserPageRequest $request): View
    {
        $user = app(FindUserAction::class)->run($request->id);

        return view('appSection@admin::user_page', [
            'user' => $user,
        ]);
    }

    public function adminTools(): View
    {
        return view('appSection@admin::admin_tools');
    }

    public function hashingView(): View
    {
        return view('appSection@admin::hashing');
    }

    public function hashingEncode(HashingEncodeRequest $request): array
    {
        return ['hash' => $request->encode($request->get('id'))];
    }

    public function hashingDecode(HashingDecodeRequest $request): array
    {
        /** @var HashingDecodeTransporter $data */
        $data = $request->toTransporter();

        return ['id' => $data->hashed];
    }

    public function xhprof(): Redirector|Application|RedirectResponse
    {
        return redirect(config('app.url') . ':8080');
    }

    public function centrifugo(): Redirector|Application|RedirectResponse
    {
        return redirect(config('app.url') . ':8000');
    }

    public function rabbitmq(): Redirector|Application|RedirectResponse
    {
        return redirect(config('app.url') . ':15672');
    }

    public function salesforceImportStatus(): View
    {
        $imports = app(FindAllSalesforceImportsTask::class)->run();

        $importExceptions = app(GetAllSalesforceImportExceptionsTasks::class)->run();
        $exportExceptions = app(GetAllSalesforceExportExceptionsTasks::class)->withRelations(['salesforceObject'])->run();

        return view('appSection@admin::salesforce_import_status', [
            'imports'          => $imports,
            'importExceptions' => $importExceptions,
            'exportExceptions' => $exportExceptions,
        ]);
    }

    public function salesforceImportStatusData(): array
    {
        $imports = app(FindAllSalesforceImportsTask::class)->run();

        return $this->transform($imports, new SalesforceImportsTransformer());
    }

    public function salesforceApiStatus(): JsonResponse
    {
        $status = true;

        try {
            app(SalesforceApiService::class)->ping()->status();
        } catch (Exception) {
            $status = false;
        }

        return $this->json(['status' => $status]);
    }

    public function tryExportException(TryExportExceptionRequest $request): JsonResponse
    {
        $status = app(TryExportExceptionAction::class)->run($request->toTransporter()) ? Response::HTTP_NO_CONTENT : Response::HTTP_BAD_REQUEST;

        return $this->noContent($status);
    }

    public function clientVideos(): View
    {
        $clientHelp = app(GetAllClientHelpAction::class)->run();

        return view('appSection@admin::client_videos', ['help' => $clientHelp]);
    }

    public function editClientVideos(EditClientVideoPageRequest $request): View
    {
        $clientHelp = app(GetClientHelpAction::class)->run($request->toTransporter());

        return view('appSection@admin::edit_client_help', ['help' => $clientHelp]);
    }

    public function submitClientVideos(SubmitClientVideoRequest $request): void
    {
    }
}
