<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Containers\AppSection\User\Data\Transporters\UpdateUserTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Parents\Actions\Action;

class UpdateUserAction extends Action
{
    public function run(UpdateUserTransporter $userData): User
    {
        $input = $userData->toArray();

        $user = app(UpdateUserTask::class)->run($input, $userData->id);

        app(AttachMediaFromUuidsToModelSubAction::class)->run($user, $userData->uuids, MediaCollectionEnum::AVATAR);

        return $user;
    }
}
