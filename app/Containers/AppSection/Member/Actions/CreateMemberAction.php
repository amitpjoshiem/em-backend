<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Activity\Events\Events\ProspectAddedEvent;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Data\Transporters\CreateMemberTransporter;
use App\Containers\AppSection\Member\Data\Transporters\MemberTransporter;
use App\Containers\AppSection\Member\Events\Events\CreateMemberEvent;
use App\Containers\AppSection\Member\Exceptions\SpouseRequiredException;
use App\Containers\AppSection\Member\Exceptions\WrongHouseTypeException;
use App\Containers\AppSection\Member\Exceptions\WrongOtherRiskException;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\CreateEmploymentHistoryTask;
use App\Containers\AppSection\Member\Tasks\CreateMemberContactTask;
use App\Containers\AppSection\Member\Tasks\CreateMemberHouseTask;
use App\Containers\AppSection\Member\Tasks\CreateMemberOtherTask;
use App\Containers\AppSection\Member\Tasks\CreateMemberTask;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class CreateMemberAction extends Action
{
    /**
     * @throws CreateResourceFailedException
     * @throws NotFoundException
     * @throws SpouseRequiredException
     * @throws UserNotFoundException
     * @throws ValidatorException
     * @throws WrongHouseTypeException
     * @throws WrongOtherRiskException
     * @throws RepositoryException
     */
    public function run(CreateMemberTransporter $memberData): ?Member
    {
        $input = new MemberTransporter($memberData->toArray());

        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $input->user_id = $user->id;
        $input->step    = MemberStepsEnum::BASIC;

        $member = app(CreateMemberTask::class)->run($input->toArray());

        if (isset($memberData->house)) {
            app(CreateMemberHouseTask::class)->run($member->id, $memberData->house);
        }

        if (isset($memberData->other)) {
            app(CreateMemberOtherTask::class)->run($member->id, $memberData->other);
        }

        if ($member->married) {
            if (!isset($memberData->spouse)) {
                throw new SpouseRequiredException();
            }

            $spouse = app(CreateMemberContactTask::class)->run($member->id, $memberData->spouse->toArray(), true);

            if (property_exists($memberData->spouse, 'employment_history') && $memberData->spouse->employment_history !== null) {
                app(CreateEmploymentHistoryTask::class)->run($spouse->id, MemberContact::TYPE, $memberData->spouse->employment_history);
            }
        }

        if (isset($memberData->employment_history)) {
            app(CreateEmploymentHistoryTask::class)->run($member->id, Member::TYPE, $memberData->employment_history);
        }

        /** @var Member $member */
        $member = app(FindMemberByIdTask::class)->withRelations([
            'spouse',
            'spouse.employmentHistory',
            'house',
            'employmentHistory',
        ])->run($member->id);

        event(new CreateMemberEvent($member));

        event(new ProspectAddedEvent($user->getKey(), $member->getKey()));

        return $member;
    }
}
