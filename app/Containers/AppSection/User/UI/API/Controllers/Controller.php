<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\CLI\Commands;

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Containers\AppSection\User\Actions\CreateClientAction;
use App\Containers\AppSection\User\Actions\CreatePasswordAction;
use App\Containers\AppSection\User\Actions\DeleteUserAction;
use App\Containers\AppSection\User\Actions\EmailVerificationAction;
use App\Containers\AppSection\User\Actions\FindUserByIdAction;
use App\Containers\AppSection\User\Actions\ForgotPasswordAction;
use App\Containers\AppSection\User\Actions\GetAdvisorAssistantsAction;
use App\Containers\AppSection\User\Actions\GetAllAdminsAction;
use App\Containers\AppSection\User\Actions\GetAllClientsAction;
use App\Containers\AppSection\User\Actions\GetAllCompaniesAction;
use App\Containers\AppSection\User\Actions\GetAllUsersAction;
use App\Containers\AppSection\User\Actions\GetAssistantAdvisorsAction;
use App\Containers\AppSection\User\Actions\GetAuthenticatedUserAction;
use App\Containers\AppSection\User\Actions\GetUsersStatsAction;
use App\Containers\AppSection\User\Actions\RegisterUserAction;
use App\Containers\AppSection\User\Actions\ResendEmailVerificationAction;
use App\Containers\AppSection\User\Actions\ReSendLeadCreatePasswordAction;
use App\Containers\AppSection\User\Actions\ResetPasswordAction;
use App\Containers\AppSection\User\Actions\SendVerifyPhoneAction;
use App\Containers\AppSection\User\Actions\UpdatePasswordAction;
use App\Containers\AppSection\User\Actions\UpdateUserAction;
use App\Containers\AppSection\User\Actions\UpdateUserEmailAction;
use App\Containers\AppSection\User\Actions\VerifyPhoneAction;
use App\Containers\AppSection\User\UI\API\Requests\CreateAdminRequest;
use App\Containers\AppSection\User\UI\API\Requests\CreateClientRequest;
use App\Containers\AppSection\User\UI\API\Requests\CreatePasswordRequest;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserRequest;
use App\Containers\AppSection\User\UI\API\Requests\EmailVerificationRequest;
use App\Containers\AppSection\User\UI\API\Requests\FindUserByIdRequest;
use App\Containers\AppSection\User\UI\API\Requests\ForgotPasswordRequest;
use App\Containers\AppSection\User\UI\API\Requests\GetAllCompaniesRequest;
use App\Containers\AppSection\User\UI\API\Requests\GetAllUsersRequest;
use App\Containers\AppSection\User\UI\API\Requests\GetAuthenticatedUserRequest;
use App\Containers\AppSection\User\UI\API\Requests\RegisterUserRequest;
use App\Containers\AppSection\User\UI\API\Requests\ResendEmailVerificationRequest;
use App\Containers\AppSection\User\UI\API\Requests\ReSendLeadCreatePasswordRequest;
use App\Containers\AppSection\User\UI\API\Requests\ResetPasswordRequest;
use App\Containers\AppSection\User\UI\API\Requests\SendVerifyPhoneRequest;
use App\Containers\AppSection\User\UI\API\Requests\UpdatePasswordRequest;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserEmailRequest;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use App\Containers\AppSection\User\UI\API\Requests\VerifyPhoneRequest;
use App\Containers\AppSection\User\UI\API\Transformers\CompanyTransformer;
use App\Containers\AppSection\User\UI\API\Transformers\UsersStatsTransformer;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class Controller extends ApiController
{
    public function registerUser(RegisterUserRequest $request): JsonResponse
    {
        $user = DB::transaction(fn () => app(RegisterUserAction::class)->run($request->toTransporter()));

        if (config('appSection-authentication.require_email_confirmation')) {
            return $this->accepted(['message' => 'Further instructions were sent to your email.']);
        }

        return $this->created($this->transform($user, UserTransformer::class));
    }

    public function sendForgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = app(ForgotPasswordAction::class)->run($request);

        return $this->json(['message' => $status]);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        app(ResetPasswordAction::class)->run($request);

        return $this->noContent();
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        app(UpdatePasswordAction::class)->run($request);

        return $this->accepted(['message' => 'Password successfully changed.']);
    }

    public function resendEmailVerification(ResendEmailVerificationRequest $request): JsonResponse
    {
        $isEmailResend = app(ResendEmailVerificationAction::class)->run();

        if ($isEmailResend) {
            return $this->accepted(['message' => 'Email verification link sent on your email.']);
        }

        return $this->noContent();
    }

    public function verifyUserEmail(EmailVerificationRequest $request): JsonResponse
    {
        app(EmailVerificationAction::class)->run($request);

        return $this->accepted(['message' => 'Your email was successfully verified.']);
    }

    public function getAuthenticatedUser(GetAuthenticatedUserRequest $request): array
    {
        $user = app(GetAuthenticatedUserAction::class)->run();

        return $this->transform($user, UserTransformer::class);
    }

    public function updateUser(UpdateUserRequest $request): array
    {
        $user = app(UpdateUserAction::class)->run($request->toTransporter());

        return $this->transform($user, UserTransformer::class);
    }

    public function updateUserEmail(UpdateUserEmailRequest $request): JsonResponse
    {
        app(UpdateUserEmailAction::class)->run($request);

        return $this->accepted(['message' => 'Email verification link sent on your email.']);
    }

    public function deleteUser(DeleteUserRequest $request): JsonResponse
    {
        app(DeleteUserAction::class)->run($request);

        return $this->noContent();
    }

    public function getAllUsers(GetAllUsersRequest $request): array
    {
        $users = app(GetAllUsersAction::class)->run();

        return $this->transform($users, UserTransformer::class);
    }

    public function findUserById(FindUserByIdRequest $request): array
    {
        $user = app(FindUserByIdAction::class)->run($request);

        return $this->transform($user, UserTransformer::class);
    }

    public function createAdmin(CreateAdminRequest $request): array
    {
        $admin = app(CreateAdminAction::class)->run($request->toTransporter());

        return $this->transform($admin, UserTransformer::class);
    }

    public function getAllClients(GetAllUsersRequest $request): array
    {
        $users = app(GetAllClientsAction::class)->run();

        return $this->transform($users, UserTransformer::class);
    }

    public function getAllAdmins(GetAllUsersRequest $request): array
    {
        $users = app(GetAllAdminsAction::class)->run();

        return $this->transform($users, UserTransformer::class);
    }

    public function createUserPassword(CreatePasswordRequest $request): JsonResponse
    {
        app(CreatePasswordAction::class)->run($request);

        return $this->noContent();
    }

    public function sendVerifyPhone(SendVerifyPhoneRequest $request): JsonResponse
    {
        app(SendVerifyPhoneAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function verifyPhone(VerifyPhoneRequest $request): JsonResponse
    {
        app(VerifyPhoneAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function createClient(CreateClientRequest $request): JsonResponse
    {
        app(CreateClientAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function reSendLeadCreatePassword(ReSendLeadCreatePasswordRequest $request): JsonResponse
    {
        app(ReSendLeadCreatePasswordAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllCompanies(GetAllCompaniesRequest $request): array
    {
        $companies = app(GetAllCompaniesAction::class)->run();

        return $this->transform($companies, new CompanyTransformer(), resourceKey: 'companies');
    }

    public function getUsersStats(): array
    {
        $stats = app(GetUsersStatsAction::class)->run();

        return $this->transform($stats, new UsersStatsTransformer(), resourceKey: 'stats');
    }

    public function getAssistantAdvisors(): array
    {
        $advisors = app(GetAssistantAdvisorsAction::class)->run();

        return $this->transform($advisors, new UserTransformer(), resourceKey: 'advisors');
    }

    public function getAdvisorAssistants(): array
    {
        $assistants = app(GetAdvisorAssistantsAction::class)->run();

        return $this->transform($assistants, new UserTransformer(), resourceKey: 'assistants');
    }
}
