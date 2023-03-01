<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\ApiRequestException;
use  App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAccountException;
use Arr;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use JsonException;

final class User extends Api
{
    /**
     * @var string
     */
    private const OBJECT_NAME = 'User';

    public function getObjectName(): string
    {
        return self::OBJECT_NAME;
    }

    /**
     * @var string
     *
     * @param string SalesforceAppLink
     */
    private const PRINTF_AUTH_LINK = '%s/services/oauth2/authorize?%s';

    public function getSalesforceAuthLink(string $userId): string
    {
        return sprintf(
            self::PRINTF_AUTH_LINK,
            $this->getInstance(),
            Arr::query([
                'response_type'     => 'code',
                'client_id'         => config('appSection-salesforce.clientId'),
                'redirect_uri'      => route('web_salesforce_auth_callback'),
                'state'             => $userId,
            ])
        );
    }

    /**
     * @throws FindSalesforceAccountException
     * @throws JsonException
     */
    public function authenticateUser(string $code): string
    {
        $url  = config('appSection-salesforce.login_url');
        $data = [
            'grant_type'        => 'authorization_code',
            'code'              => $code,
            'client_id'         => config('appSection-salesforce.clientId'),
            'client_secret'     => config('appSection-salesforce.clientSecret'),
            'redirect_uri'      => route('web_salesforce_auth_callback'),
        ];
        /** @var Response $response */
        $response = Http::withHeaders([
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Accept'        => 'application/json',
        ])->asForm()->post($url, $data);

        if (!$response->successful()) {
            throw new ApiRequestException('post', $url, $response->json(), $data);
        }

        $content =  $response->json();

        preg_match('#id\/.*\/(.*)$#', $content['id'], $match);

        return $match[1];
    }
}
