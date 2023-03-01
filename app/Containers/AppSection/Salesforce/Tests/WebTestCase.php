<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tests;

use Illuminate\Support\Facades\Config;

/**
 * Class WebTestCase.
 *
 * This is the container WEB TestCase class. Use this class to add your container specific WEB related helper functions.
 */
class WebTestCase extends TestCase
{
    /** @psalm-suppress MissingParamType */
    public function buildUrlForUri($uri): string
    {
        return Config::get('apiato.api.url') . '/' . ltrim($uri, '/');
    }
}
