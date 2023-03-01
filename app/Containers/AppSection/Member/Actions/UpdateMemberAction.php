<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Activity\Events\Events\MemberUpdateBasicInfoEvent;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\SubActions\AttachMediaFromUuidsToModelSubAction;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Data\Transporters\MemberTransporter;
use App\Containers\AppSection\Member\Data\Transporters\UpdateMemberTransporter;
use App\Containers\AppSection\Member\Events\Events\UpdateMemberEvent;
use App\Containers\AppSection\Member\Exceptions\MissedEmployesHistoryId;
use App\Containers\AppSection\Member\Exceptions\WrongHouseTypeException;
use App\Containers\AppSection\Member\Exceptions\WrongOtherRiskException;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\SubActions\UpdateEmploymentHistorySubAction;
use App\Containers\AppSection\Member\Tasks\DeleteAllEmploymentHistoryByPersonTask;
use App\Containers\AppSection\Member\Tasks\GetMemberStepOrder;
use App\Containers\AppSection\Member\Tasks\UpdateMemberContactTask;
use App\Containers\AppSection\Member\Tasks\UpdateMemberHouseTask;
use App\Containers\AppSection\Member\Tasks\UpdateMemberOtherTask;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class UpdateMemberAction extends Action
{
    /**
     * @throws UpdateResourceFailedException
     * @throws ValidatorException
     * @throws WrongHouseTypeException
     * @throws MissedEmployesHistoryId
     * @throws WrongOtherRiskException
     */
    public function run(UpdateMemberTransporter $memberData): Member
    {
        $user  = app(GetStrictlyAuthenticatedUserTask::class)->run();
        $input = new MemberTransporter($memberData->toArray());

        /** @var Member $member */
        $member = app(UpdateMemberTask::class)->run($memberData->id, $input->toArray());

        if (isset($memberData->house)) {
            app(UpdateMemberHouseTask::class)->run($member->id, $memberData->house->toArray());
        }

        if (isset($memberData->other)) {
            app(UpdateMemberOtherTask::class)->run($member->id, $memberData->other->toArray());
        }

        if ($member->married && isset($memberData->spouse)) {
            $spouseEmploymentHistory = null;

            /** @noRector IssetOnPropertyObjectToPropertyExistsRector */
            if (isset($memberData->spouse->employment_history)) {
                $spouseEmploymentHistory = $memberData->spouse->employment_history;
                unset($memberData->spouse->employment_history);
            }

            /** @var MemberContact $spouse */
            $spouse = app(UpdateMemberContactTask::class)->run($member->id, array_merge($memberData->spouse->toArray(), ['is_spouse' => true]));

            if ($spouseEmploymentHistory !== null) {
                if (empty($spouseEmploymentHistory)) {
                    app(DeleteAllEmploymentHistoryByPersonTask::class)->run($spouse);
                } else {
                    app(UpdateEmploymentHistorySubAction::class)->run($spouseEmploymentHistory, $spouse->getKey(), MemberContact::TYPE);
                }
            }
        }

        if (isset($memberData->employment_history)) {
            if (empty($memberData->employment_history)) {
                app(DeleteAllEmploymentHistoryByPersonTask::class)->run($member);
            } else {
                app(UpdateEmploymentHistorySubAction::class)->run($memberData->employment_history, $member->getKey(), Member::TYPE);
            }
        }

        $currentStepCount = app(GetMemberStepOrder::class)->run($member->step);
        $basicStep        = app(GetMemberStepOrder::class)->run(MemberStepsEnum::BASIC);

        if ($currentStepCount < $basicStep) {
            $member = app(UpdateMemberTask::class)->run($member->getKey(), ['step' => MemberStepsEnum::BASIC]);
        }

        app(AttachMediaFromUuidsToModelSubAction::class)->run($member, $memberData->uuids, MediaCollectionEnum::AVATAR);

        event(new UpdateMemberEvent($member));
        event(new MemberUpdateBasicInfoEvent($user->getKey(), $member->getKey()));

        return $member;
    }
}
