<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Blueprint\Data\Enums\BlueprintDocStatusEnum;
use App\Containers\AppSection\Blueprint\Data\Enums\BlueprintDocTypeEnum;
use App\Containers\AppSection\Blueprint\Data\Transporters\GenerateBlueprintPdfTransporter;
use App\Containers\AppSection\Blueprint\Events\Events\GeneratePdfEvent;
use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Containers\AppSection\Blueprint\Tasks\CreateBlueprintDocTask;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;

class GeneratePdfAction extends Action
{
    public function run(GenerateBlueprintPdfTransporter $input): void
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->run($input->member_id);
        /** @var BlueprintDoc $doc */
        $doc = app(CreateBlueprintDocTask::class)->run([
            'user_id'    => $user->getKey(),
            'member_id'  => $member->getKey(),
            'media_id'   => null,
            'type'       => BlueprintDocTypeEnum::PDF,
            'filename'   => sprintf('%s_%d.pdf', str_replace(' ', '_', $member->name), now()->timestamp),
            'status'     => BlueprintDocStatusEnum::PROCESS,
        ]);

        event(new GeneratePdfEvent($doc->getKey()));
    }
}
