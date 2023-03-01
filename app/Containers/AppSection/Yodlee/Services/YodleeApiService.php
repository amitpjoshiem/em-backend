<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Services;

use App\Containers\AppSection\Yodlee\Exceptions\BaseException;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class YodleeApiService
{
    /**
     * @var string
     */
    private const AUTH_URL = '%s/auth/token';

    /**
     * @var string
     */
    public const HTTP_GET = 'get';

    /**
     * @var string
     */
    public const HTTP_POST = 'post';

    /**
     * @var string
     */
    public const HTTP_PUT = 'put';

    /**
     * @var string
     */
    public const HTTP_PATCH = 'patch';

    /**
     * @var string
     */
    public const HTTP_DELETE = 'delete';

    protected string $apiVer;

    protected string $apiUrl;

    abstract public function getTokenCacheKey(): string;

    public function __construct(private string $loginName)
    {
        $this->apiVer = config('appSection-yodlee.api_ver');
        $this->apiUrl = config('appSection-yodlee.api_url');
    }

    /**
     * @throws BaseException
     */
    private function login(string $loginName): void
    {
        $url      = sprintf(self::AUTH_URL, $this->apiUrl);
        $response = Http::withHeaders([
            'Api-Version'       => $this->apiVer,
            'loginName'         => $loginName,
        ])->asForm()->post($url, [
            'clientId'  => config('appSection-yodlee.client_id'),
            'secret'    => config('appSection-yodlee.client_secret'),
        ]);

        if (!$response->successful()) {
            throw new BaseException();
        }

        $content = $response->json();
        Cache::add($this->getTokenCacheKey(), $content['token']['accessToken'], $content['token']['expiresIn']);
    }

    protected function getToken(): string
    {
        if (!$this->isAuthenticated()) {
            $this->login($this->loginName);
        }

        return Cache::get($this->getTokenCacheKey());
    }

    private function isAuthenticated(): bool
    {
        return Cache::has($this->getTokenCacheKey());
    }

    /**
     * @throws BaseException
     */
    public function status(): void
    {
        $this->login($this->loginName);
    }

    /**
     * @throws BaseException
     */
    protected function sendRequest(string $type, string $url, array $data = []): PromiseInterface|Response
    {
        return self::send($this->getToken(), $this->apiVer, $type, $url, $data);
    }

    public static function send(string $token, string $apiVer, string $type, string $url, array $data = []): PromiseInterface|Response
    {
        /** @var PromiseInterface|Response $response */
        $response = Http::withToken($token)->withHeaders([
            'Api-Version'   => $apiVer,
        ])->{$type}($url, $data);

        if (!$response->successful()) {
            $content = $response->json();
            Log::error('Yodlee Exception', [
                'inputData'         => $data,
                'yodleeResponce'    => $content,
            ]);
            throw new BaseException($content['errorMessage']);
        }

        return $response;
    }
}
