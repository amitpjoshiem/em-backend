<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Policies;

use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Authorization\Tasks\HasRoleTask;
use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Models\UserModel;
use App\Ship\Parents\Policies\Policy;
use Illuminate\Auth\Access\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MediaPolicy extends Policy
{
    public function __construct(private HasRoleTask $hasRoleTask)
    {
    }

    /**
     * Determine whether the user can delete the media.
     */
    public function delete(UserModel $user, Media $media): Response
    {
        $model = $media->model;

        if (!($model instanceof HasInteractsWithMedia)) {
            return $this->deny(code: SymfonyResponse::HTTP_FORBIDDEN);
        }

        if ($user->getKey() !== $model->getAuthorId()) {
            return $this->deny(code: SymfonyResponse::HTTP_FORBIDDEN);
        }

        return $this->allow();
    }

    /**
     * Determine whether the user can upload media to the InvestmentReview.
     */
    public function create(UserModel $user): Response
    {
        return match (true) {
            $this->hasRoleTask->run($user, RolesEnum::advisor()) => $this->deny(),
            default                                           => $this->allow(),
        };
    }

    /**
     * Determine whether the user can upload media to the InvestmentReview.
     */
    public function list(UserModel $user): Response
    {
        return match (true) {
            $this->hasRoleTask->run($user, RolesEnum::advisor()) => $this->deny(),
            default                                           => $this->allow(),
        };
    }
}
