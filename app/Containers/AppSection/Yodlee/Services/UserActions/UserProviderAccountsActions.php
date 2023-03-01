<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services\UserActions;

use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\YodleeApiService;
use Illuminate\Support\Facades\Log;

class UserProviderAccountsActions extends UserAbstractAction implements UserActionInterface
{
    /**
     * @var string
     */
    private const GET_PROVIDER_ACCOUNTS_URL = '%s/providerAccounts';

    public function getAll(): array
    {
        $url      = sprintf(self::GET_PROVIDER_ACCOUNTS_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['providerAccount'])) {
            Log::error('User Provider Accounts Error', ['yodleeResponse' => $response->json()]);
            throw new BaseException('Can`t get User Provider Accounts');
        }

        return $content['providerAccount'];
    }
}
