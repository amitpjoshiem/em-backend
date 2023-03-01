<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Tests\Traits;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Containers\AppSection\Member\Models\MemberOther;
use Illuminate\Database\Eloquent\Collection;

trait RegisterMemberTestTrait
{
    public function getMemberRegisterData(bool $withSpouse = true): array
    {
        $data = Member::factory()->make(['type' => Member::PROSPECT])->toArray();

        $data['married'] = $withSpouse;

        if ($withSpouse) {
            $data['spouse']                       = MemberContact::factory()->make()->toArray();
            $data['spouse']['employment_history'] = MemberEmploymentHistory::factory()->count(random_int(3, 5))->make()->toArray();
        }

        $data['house'] = MemberHouse::factory()->make()->toArray();

        $data['other'] = MemberOther::factory()->make()->toArray();

        $data['employment_history'] = MemberEmploymentHistory::factory()->count(random_int(3, 5))->make()->toArray();

        return $data;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType
     */
    public function registerMember(int $userId, bool $withSpouse = true): Member
    {
        /** @var Member $member */
        $member = Member::factory()->make([
            'user_id'   => $userId,
            'type'      => Member::PROSPECT,
        ]);

        $member->married = $withSpouse;

        $member->save();

        if ($withSpouse) {
            /** @var MemberContact $spouse */
            $spouse = MemberContact::factory()->make(['is_spouse' => true]);
            $member->contacts()->save($spouse);
            $member->spouse->employmentHistory()->saveMany(MemberEmploymentHistory::factory()->count(random_int(1, 5))->make());
        }

        /** @var MemberHouse $memberHouse */
        $memberHouse = MemberHouse::factory()->make();
        $member->house()->save($memberHouse);

        /** @var MemberOther $memberOther */
        $memberOther = MemberOther::factory()->make();
        $member->other()->save($memberOther);

        /** @var Collection $memberEmploymentHistory */
        $memberEmploymentHistory = MemberEmploymentHistory::factory()->count(random_int(1, 5))->make();
        $member->employmentHistory()->saveMany($memberEmploymentHistory);

        return Member::with('spouse', 'spouse.employmentHistory', 'employmentHistory', 'house', 'other')->find($member->id);
    }
}
