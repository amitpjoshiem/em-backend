<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Events\Events;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use Faker\Generator;
use Vinkla\Hashids\Facades\Hashids;

class LeadAddedEvent extends AbstractActivityEvent
{
    public function __construct(int $userId, int $memberId)
    {
        $member = app(FindMemberByIdTask::class)->run($memberId);
        parent::__construct($userId, ['member_id' => $member->getKey(), 'member_name' => $member->name]);
    }

    public static function getActivityHtmlString(array $data): string
    {
        $url = sprintf(config('appSection-activity.client_confirmation_printf_url'), config('app.frontend_url'), Hashids::encode($data['member_id']));

        return sprintf("<p>New Lead <a href='%s'>%s</a> added</p>", $url, $data['member_name']);
    }

    public static function seedActivity(Generator $faker, int $userId): array
    {
        /** @var Member $randomMember */
        $randomMember = Member::all()->where('user_id', value: $userId)->where('type', value: Member::LEAD)->random();

        return [
            'member_id'     => $randomMember->getKey(),
            'member_name'   => $randomMember->name,
        ];
    }
}
