<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services;

use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\UserActions\UserAccountsActions;
use App\Containers\AppSection\Yodlee\Services\UserActions\UserProvidersActions;
use App\Containers\AppSection\Yodlee\Services\UserActions\UserTransactionsActions;
use Illuminate\Support\Facades\Log;

class YodleeUserApiService extends YodleeApiService
{
    /**
     * @var string
     */
    private const USER_TOKEN_CACHE_KEY = 'yodlee:%s:token';

    /**
     * @var string
     */
    private const DELETE_USER_URL = '%s/user/unregister';

    /**
     * @var string
     */
    private const USER_URL = '%s/user';

    public function __construct(string $loginName, private int $userId)
    {
        parent::__construct($loginName);
    }

    public function getTokenCacheKey(): string
    {
        return sprintf(self::USER_TOKEN_CACHE_KEY, $this->userId);
    }

    public function deleteUser(): void
    {
        $url      = sprintf(self::DELETE_USER_URL, $this->apiUrl);
        $this->sendRequest(
            YodleeApiService::HTTP_DELETE,
            $url
        );
    }

    public function profile(): array
    {
        $url      = sprintf(self::USER_URL, $this->apiUrl);
        $response = $this->sendRequest(YodleeApiService::HTTP_GET, $url);
        $content  = $response->json();

        if (!isset($content['user'])) {
            Log::error('Error deleting User from Yodlee', ['yodleeResponse' => $content]);
            throw new BaseException('Can`t delete user from yodlee');
        }

        return $content['user'];
    }

    public function providers(): UserProvidersActions
    {
        return new UserProvidersActions($this->getToken());
    }

    public function accounts(): UserAccountsActions
    {
        return new UserAccountsActions($this->getToken());
    }

    public function transactions(): UserTransactionsActions
    {
        return new UserTransactionsActions($this->getToken());
    }

    public function getUserToken(): string
    {
        return parent::getToken();
    }
}
