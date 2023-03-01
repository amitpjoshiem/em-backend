<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use GuzzleHttp\Utils;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CallOAuthServerTask extends Task
{
    public function __construct(private Application $app)
    {
    }

    /**
     * @throws LoginFailedException|Exception
     */
    public function run(array $data): array
    {
        $headers = [
            'HTTP_ACCEPT'          => 'application/json',
            'HTTP_X_FORWARDED_FOR' => $data['client_ip'],
            'HTTP_ACCEPT_LANGUAGE' => $data['locale'],
        ];

        // Create and handle the oauth request
        $request = Request::create($this->getAuthFullApiUrl(), 'POST', $data, [], [], $headers);

        $response = $this->app->handle($request);

        $content = $response->getContent();

        if ($content === false) {
            throw new LoginFailedException();
        }

        // Response content as Array
        $content = (array)Utils::jsonDecode($content, true);

        // If the internal request to the oauth token endpoint was not successful we throw an exception
        if (!$response->isSuccessful()) {
            $msg = $this->getMsgError($content);
            throw (new LoginFailedException($msg, $response->getStatusCode()))->withErrors(['login' => $msg]);
        }

        return $content;
    }

    /**
     * @FIXME : thinking about it
     *
     * @throws LoginFailedException
     */
    public function theOtherRun(array $data): array
    {
        $headers = [
            'HTTP_ACCEPT'          => 'application/json',
            'HTTP_X_FORWARDED_FOR' => $data['client_ip'],
            'HTTP_ACCEPT_LANGUAGE' => $data['locale'],
        ];

        // Create and handle the oauth request
        $response = Http::withOptions(['verify' => $this->isVerified()])
            ->withHeaders($headers)
            ->post($this->getAuthFullApiUrl(), $data);

        // Response content as Array
        $content = (array)$response->json();

        if ($content === []) {
            throw new LoginFailedException();
        }

        // If the internal request to the oauth token endpoint was not successful we throw an exception
        if (!$response->ok()) {
            $msg = $this->getMsgError($content);
            throw (new LoginFailedException($msg, $response->status()))->withErrors(['login' => $msg]);
        }

        return $content;
    }

    /**
     * Full url of the oauth token endpoint.
     */
    private function getAuthFullApiUrl(): string
    {
        return route('passport.token');
    }

    private function getMsgError(array $content): string
    {
        return config('app.debug') ? $content['message'] : (string)trans('appSection@authentication::messages.login-failed-msg');
    }

    /**
     * Check do we need disable verify (for local env).
     */
    private function isVerified(): bool
    {
        return !$this->app->isLocal() && !$this->app->runningUnitTests();
    }
}
