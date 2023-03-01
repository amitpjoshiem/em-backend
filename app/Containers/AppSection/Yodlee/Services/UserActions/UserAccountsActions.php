<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services\UserActions;

use App\Containers\AppSection\Yodlee\Data\Transporters\YodleeAccountTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\YodleeApiService;
use Illuminate\Support\Facades\Log;

class UserAccountsActions extends UserAbstractAction implements UserActionInterface
{
    /**
     * @var string
     */
    private const ACCOUNTS_URL = '%s/accounts';

    /**
     * @var string
     */
    private const ACCOUNT_ID_URL = '%s/accounts/%d';

    /**
     * @var string
     */
    private const GET_ACCOUNT_HISTORICAL_BALANCES_URL = '%s/accounts/historicalBalances';

    public function getAll(array $params = []): array
    {
        $url      = sprintf(self::ACCOUNTS_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url, $params);
        $content  = $response->json();

        return $content['account'] ?? [];
    }

    public function create(YodleeAccountTransporter $input): array
    {
        $url      = sprintf(self::ACCOUNTS_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_POST, $url, $input->toArray());
        $content  = $response->json();

        if (!isset($content['account'][0])) {
            Log::error('User create Account Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t create User Account');
        }

        return $content['account'][0];
    }

    public function get(int $id): array
    {
        $url      = sprintf(self::ACCOUNT_ID_URL, $this->url, $id);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['account'][0])) {
            Log::error('User Account Details Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t get User Account Details');
        }

        return $content['account'][0];
    }

    public function getHistoricalBalances(): array
    {
        $url      = sprintf(self::GET_ACCOUNT_HISTORICAL_BALANCES_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['account'])) {
            Log::error('User Account Historical Balances Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t get User Account Historical Balances');
        }

        return $content['account'];
    }

    public function update(YodleeAccountTransporter $input, int $accountId): void
    {
        $url = sprintf(self::ACCOUNT_ID_URL, $this->url, $accountId);
        $this->sendRequest(YodleeApiService::HTTP_PUT, $url, $input->toArray());
    }

    public function delete(int $id): void
    {
        $url      = sprintf(self::ACCOUNT_ID_URL, $this->url, $id);
        $this->sendRequest(YodleeApiService::HTTP_DELETE, $url);
    }

    public function getAccountsByProviderId(int $providerId): array
    {
        $accounts = $this->getAll();
        foreach ($accounts as $key => $account) {
            if ((int)$account['providerId'] !== $providerId) {
                unset($accounts[$key]);
            }
        }

        return $accounts;
    }

    public function providerAccounts(): UserProviderAccountsActions
    {
        return new UserProviderAccountsActions($this->token);
    }
}
