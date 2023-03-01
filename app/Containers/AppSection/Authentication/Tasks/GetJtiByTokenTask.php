<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token\Plain;
use Lcobucci\JWT\Token\RegisteredClaims;

class GetJtiByTokenTask extends Task
{
    public function __construct(private Parser $parser)
    {
    }

    public function run(string $token): string | null
    {
        /** @var Plain $plainToken */
        $plainToken = $this->parser->parse($token);

        return $plainToken
            ->claims()
            ->get(RegisteredClaims::ID);
    }
}
