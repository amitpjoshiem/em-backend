<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services;

use App\Containers\AppSection\Yodlee\Data\Transporters\YodleeUserTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\BaseException;

class YodleeAdminApiService extends YodleeApiService
{
    /**
     * @var string
     */
    private const ADMIN_TOKEN_CACHE_KEY = 'yodlee:token';

    /**
     * @var string
     */
    private const USER_REGISTER = '%s/user/register';

    public function __construct()
    {
        parent::__construct(config('appSection-yodlee.admin_login'));
    }

    public function getTokenCacheKey(): string
    {
        return self::ADMIN_TOKEN_CACHE_KEY;
    }

    /**
     * @throws BaseException
     */
    public function createUser(YodleeUserTransporter $userData): array
    {
        $url      = sprintf(self::USER_REGISTER, config('appSection-yodlee.api_url'));
        $response = $this->sendRequest(
            YodleeApiService::HTTP_POST,
            $url,
            ['user' => $userData->toArray()]
        );

        $content = $response->json();

        return $content['user'];
    }
}
