<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services\UserActions;

use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\YodleeApiService;
use Illuminate\Support\Facades\Log;

class UserProvidersActions extends UserAbstractAction implements UserActionInterface
{
    /**
     * @var string
     */
    private const GET_PROVIDERS_URL = '%s/providers';

    /**
     * @var string
     */
    private const GET_PROVIDERS_COUNT_URL = '%s/providers/count';

    /**
     * @var string
     */
    private const GET_PROVIDER_DETAIL_URL = '%s/providers/%d';

    public function getAll(): array
    {
        $url      = sprintf(self::GET_PROVIDERS_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['provider'])) {
            Log::error('User Providers Error', ['yodleeResponse' => $response->json()]);
            throw new BaseException('Can`t get User Providers');
        }

        return $this->map($content['provider']);
    }

    public function getCount(): int
    {
        $url      = sprintf(self::GET_PROVIDERS_COUNT_URL, $this->url);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['provider']['TOTAL']['count'])) {
            Log::error('User Providers Count Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t get User Providers Count');
        }

        return $content['provider']['TOTAL']['count'];
    }

    public function get(int $id): array
    {
        $url      = sprintf(self::GET_PROVIDER_DETAIL_URL, $this->url, $id);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['provider'][0])) {
            Log::error('User Provider Detail Error', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t get User Provider Detail');
        }

        return $content['provider'][0];
    }

    public function providerAccounts(): UserProviderAccountsActions
    {
        return new UserProviderAccountsActions($this->token);
    }
}
