<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Data\Transporters\ProxyApiLoginTransporter;
use App\Containers\AppSection\Authentication\Events\ApiLoginEvent;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use App\Containers\AppSection\Authentication\SubActions\PrepareProxyResponseSubAction;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tasks\CheckIfUserEmailIsConfirmedTask;
use App\Containers\AppSection\Authentication\Tasks\ExtractLoginCustomAttributeTask;
use App\Containers\AppSection\Authentication\Tasks\GetJtiByTokenTask;
use App\Containers\AppSection\Authentication\Tasks\GetSameSiteTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Models\UserModel;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

class ProxyApiLoginAction extends Action
{
    /**
     * @return array{response_content: mixed, refresh_cookie: mixed}
     */
    public function run(ProxyApiLoginTransporter $data): array
    {
        $sameSite        = app(GetSameSiteTask::class)->run();
        $responseContent = $this->callOAuthServer($data);

        /** @var User | null $user */
        $user = $this->extractUserFromAuthServerResponse($responseContent);

        if ($user === null) {
            throw new LoginFailedException();
        }

        $this->processEmailConfirmationIfNeeded($user);

        $proxyResponse = app(PrepareProxyResponseSubAction::class)->run($responseContent, $sameSite);

        /** @var Token $token */
        $token = $this->getTokenByAuthServerResponse($responseContent);

        event(new ApiLoginEvent($user->getKey(), $token->getKey()));

        return $proxyResponse;
    }

    private function callOAuthServer(ProxyApiLoginTransporter $data): array
    {
        $loginAttr = app(ExtractLoginCustomAttributeTask::class)->run($data);

        $requestData = [
            'username'      => $loginAttr->username, // Laravel Passport only expects 'username' parameter like 'loginAttribute'
            'client_ip'     => $data->client_ip,
            'password'      => $data->password,
            'grant_type'    => $data->grant_type,
            'client_id'     => $data->client_id,
            'client_secret' => $data->client_password,
            'scope'         => $data->scope,
            'locale'        => $data->locale,
        ];

        return app(CallOAuthServerTask::class)->run($requestData);
    }

    /**
     * Check if user email is confirmed only if that feature is enabled.
     *
     * @throws UserNotConfirmedException
     */
    private function processEmailConfirmationIfNeeded(UserModel $user): void
    {
        $isUserConfirmed = app(CheckIfUserEmailIsConfirmedTask::class)->run($user);

        if (!$isUserConfirmed) {
            throw new UserNotConfirmedException();
        }
    }

    private function extractUserFromAuthServerResponse(array $response): ?UserModel
    {
        /** @var Token $userAccessRecord */
        $userAccessRecord = $this->getTokenByAuthServerResponse($response);

        return app(FindUserByIdTask::class)->run($userAccessRecord->user_id);
    }

    private function getTokenByAuthServerResponse(array $response): ?Token
    {
        $tokenId = app(GetJtiByTokenTask::class)->run($response['access_token']);

        if ($tokenId === null) {
            return null;
        }

        return app(TokenRepository::class)->find($tokenId);
    }
}
