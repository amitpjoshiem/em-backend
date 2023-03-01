<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Data\Repositories;

use App\Containers\AppSection\Authentication\Exceptions\AuthenticationUserException;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Repositories\Repository;
use Prettus\Validator\Exceptions\ValidatorException;
use Str;

class OtpRepository extends Repository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
    ];

    public function revokeOtpTokenByUuid(string $uuid): bool
    {
        /** @var Otp | null  $otp */
        $otp = $this->findByField('external_token', $uuid)->first();

        if ($otp !== null) {
            return (bool)$otp->delete();
        }

        return false;
    }

    /**
     * @throws CreateResourceFailedException
     * @throws ValidatorException
     * @throws AuthenticationUserException
     */
    public function createTokenByUser(User $user): Otp
    {
        $token = $user->token();

        if ($token === null) {
            throw new AuthenticationUserException();
        }

        try {
            return $this->create([
                'external_token'        => Str::uuid(),
                'user_id'               => $user->getKey(),
                'oauth_access_token_id' => $token->getKey(),
                'expires_at'            => $token->getAttribute('expires_at'),
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
