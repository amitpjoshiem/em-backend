<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Tests;

use App\Containers\AppSection\Member\Tests\Traits\RegisterMemberTestTrait;
use App\Ship\Parents\Tests\PhpUnit\TestCase as ShipTestCase;

/**
 * Class TestCase.
 *
 * This is the container Main TestCase class. Use this class to add your container specific helper functions.
 */
class TestCase extends ShipTestCase
{
    use RegisterMemberTestTrait;
}