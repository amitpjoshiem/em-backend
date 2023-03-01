<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Ship\Exceptions\NotAuthorizedResourceException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Auth\Access\Gate;

class InspectAbilityTask extends Task
{
    public function __construct(private Gate $gate)
    {
    }

    /**
     * @throws NotAuthorizedResourceException
     */
    public function run(string $ability, mixed $arguments = []): void
    {
        $response = $this->gate->inspect($ability, $arguments);

        if ($response->denied()) {
            throw new NotAuthorizedResourceException($response->message(), $response->code());
        }
    }
}
