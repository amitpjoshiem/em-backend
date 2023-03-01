<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Otp\Data\Repositories\OtpRepository;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\Otp\Tasks\GetUserValidTokenTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\SubAction;
use App\Ship\Parents\Exceptions\Exception;
use Laravel\Passport\Token;
use Prettus\Validator\Exceptions\ValidatorException;
use Str;

class CreateOtpSubAction extends SubAction
{
    public function __construct(protected OtpRepository $otpRepository)
    {
    }

    /**
     * @throws CreateResourceFailedException
     * @throws ValidatorException
     */
    public function run(User $user): Otp
    {
        /** @var Token $token */
        $token =  app(GetUserValidTokenTask::class)->run($user->getKey());

        try {
            return $this->otpRepository->create([
                'external_token'               => Str::uuid()->toString(),
                'user_id'                      => $user->id,
                'oauth_access_token_id'        => $token->getKey(),
                'expires_at'                   => $token->getAttribute('expires_at'),
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException(previous: $exception);
        }
    }
}
