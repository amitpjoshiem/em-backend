<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;

class EmptyTest extends ApiTestCase
{
    protected string $endpoint = '';

    /**
     * @test
     */
    public function testEmpty(): void
    {
        $this->assertTrue(true);
    }
}
