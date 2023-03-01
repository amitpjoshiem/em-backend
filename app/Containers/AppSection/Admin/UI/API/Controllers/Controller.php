<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\API\Controllers;

use App\Containers\AppSection\Admin\Actions\AdminEditUserAction;
use App\Containers\AppSection\Admin\Actions\AdminRegisterUserAction;
use App\Containers\AppSection\Admin\Actions\CreateCompanyAction;
use App\Containers\AppSection\Admin\Actions\DeleteClientHelpVideoAction;
use App\Containers\AppSection\Admin\Actions\DeleteCompanyAction;
use App\Containers\AppSection\Admin\Actions\DeleteUserAction;
use App\Containers\AppSection\Admin\Actions\FindClientHelpAction;
use App\Containers\AppSection\Admin\Actions\GetAllClientHelpAction;
use App\Containers\AppSection\Admin\Actions\GetAllCompaniesAction;
use App\Containers\AppSection\Admin\Actions\GetAllUsersAction;
use App\Containers\AppSection\Admin\Actions\GetCompanyAdvisorsAction;
use App\Containers\AppSection\Admin\Actions\GetCompanyByIdAction;
use App\Containers\AppSection\Admin\Actions\GetUserByIdAction;
use App\Containers\AppSection\Admin\Actions\GetUserInitAction;
use App\Containers\AppSection\Admin\Actions\RestoreUserAction;
use App\Containers\AppSection\Admin\Actions\SendCreatePasswordAction;
use App\Containers\AppSection\Admin\Actions\UpdateClientHelpAction;
use App\Containers\AppSection\Admin\Actions\UpdateCompanyAction;
use App\Containers\AppSection\Admin\UI\API\Requests\CreateCompanyRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\CreateUserRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\DeleteClientHelpVideoRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\DeleteCompanyRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\DeleteUserRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\FindClientHelpRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\GetCompanyAdvisorsRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\GetCompanyByIdRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\GetUserByIdRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\RestoreUserRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\SendCreatePasswordUserRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\UpdateClientHelpRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\UpdateCompanyRequest;
use App\Containers\AppSection\Admin\UI\API\Requests\UpdateUserRequest;
use App\Containers\AppSection\Admin\UI\API\Transformers\InitTransformer;
use App\Containers\AppSection\Client\UI\API\Transformers\HelpVideoTransformer;
use App\Containers\AppSection\User\UI\API\Transformers\CompanyTransformer;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function getAllUsers(): array
    {
        $users = app(GetAllUsersAction::class)->run();

        return $this->transform($users, new UserTransformer(), resourceKey: 'users');
    }

    public function getUserById(GetUserByIdRequest $request): array
    {
        $user = app(GetUserByIdAction::class)->run($request->toTransporter());

        return $this->transform($user, new UserTransformer(), resourceKey: 'user');
    }

    public function getInit(): array
    {
        $init = app(GetUserInitAction::class)->run();

        return $this->transform($init, new InitTransformer(), resourceKey: 'init');
    }

    public function getCompanyAdvisors(GetCompanyAdvisorsRequest $request): array
    {
        $advisors = app(GetCompanyAdvisorsAction::class)->run($request->toTransporter());

        return $this->transform($advisors, new UserTransformer(), resourceKey: 'advisors');
    }

    public function createUser(CreateUserRequest $request): array
    {
        $user = app(AdminRegisterUserAction::class)->run($request->toTransporter());

        return $this->transform($user, new UserTransformer(), resourceKey: 'user');
    }

    public function updateUser(UpdateUserRequest $request): array
    {
        $user = app(AdminEditUserAction::class)->run($request->toTransporter());

        return $this->transform($user, new UserTransformer(), resourceKey: 'user');
    }

    public function deleteUser(DeleteUserRequest $request): JsonResponse
    {
        app(DeleteUserAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function restoreUser(RestoreUserRequest $request): JsonResponse
    {
        app(RestoreUserAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function sendCreatePassword(SendCreatePasswordUserRequest $request): JsonResponse
    {
        app(SendCreatePasswordAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllCompanies(): array
    {
        $companies = app(GetAllCompaniesAction::class)->run();

        return $this->transform($companies, new CompanyTransformer(), resourceKey: 'companies');
    }

    public function getCompanyById(GetCompanyByIdRequest $request): array
    {
        $company = app(GetCompanyByIdAction::class)->run($request->toTransporter());

        return $this->transform($company, new CompanyTransformer());
    }

    public function createCompany(CreateCompanyRequest $request): array
    {
        $company = app(CreateCompanyAction::class)->run($request->toTransporter());

        return $this->transform($company, new CompanyTransformer());
    }

    public function updateCompany(UpdateCompanyRequest $request): array
    {
        $company = app(UpdateCompanyAction::class)->run($request->toTransporter());

        return $this->transform($company, new CompanyTransformer());
    }

    public function deleteCompany(DeleteCompanyRequest $request): JsonResponse
    {
        app(DeleteCompanyAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllClientHelp(): array
    {
        $help = app(GetAllClientHelpAction::class)->run();

        return $this->transform($help, new HelpVideoTransformer(), resourceKey: 'help');
    }

    protected function getClientHelpByType(FindClientHelpRequest $request): array
    {
        $help = app(FindClientHelpAction::class)->run($request->toTransporter());

        return $this->transform($help, new HelpVideoTransformer(), resourceKey: 'help');
    }

    public function updateClientHelp(UpdateClientHelpRequest $request): array
    {
        $help = app(UpdateClientHelpAction::class)->run($request->toTransporter());

        return $this->transform($help, new HelpVideoTransformer(), resourceKey: 'help');
    }

    public function deleteHelpVideo(DeleteClientHelpVideoRequest $request): JsonResponse
    {
        app(DeleteClientHelpVideoAction::class)->run($request->toTransporter());

        return $this->noContent();
    }
}
