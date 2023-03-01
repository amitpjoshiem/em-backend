<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait AuthenticationTrait
{
    /**
     * Allows Passport to authenticate users with custom fields.
     *
     * @param string $identifier
     */
    public function findForPassport($identifier): ?Model
    {
        $allowedLoginAttributes = config('appSection-authentication.login.attributes', ['email' => []]);

        /** @var Builder|Model $builder */
        $builder = $this;
        foreach (array_keys($allowedLoginAttributes) as $field) {
            $builder = $builder->orWhere($field, $identifier);
        }

        return $builder->first();
    }
}
