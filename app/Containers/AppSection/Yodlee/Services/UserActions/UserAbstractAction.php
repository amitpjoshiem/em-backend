<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services\UserActions;

use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use App\Containers\AppSection\Yodlee\Services\YodleeApiService;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;

abstract class UserAbstractAction
{
    private string $apiVer;

    protected string $url;

    public function __construct(protected string $token)
    {
        $this->apiVer = config('appSection-yodlee.api_ver');
        $this->url    = config('appSection-yodlee.api_url');
    }

    protected function map(array $data, string $key = 'id'): array
    {
        $mappedData = [];
        foreach ($data as $value) {
            $mappedData[$value[$key]] = $value;
        }

        return $mappedData;
    }

    /**
     * @throws BaseException
     */
    protected function sendRequest(string $type, string $url, array $data = []): PromiseInterface|Response
    {
        return YodleeApiService::send($this->token, $this->apiVer, $type, $url, $data);
    }
}
