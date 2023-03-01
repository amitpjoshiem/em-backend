<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Passport;

use Laravel\Passport\Client;

class PkceClient extends Client
{
    /**
     * @inheritdoc
     */
    public function skipsAuthorization(): bool
    {
        return $this->firstParty();
    }
}
