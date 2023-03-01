<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Events;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use Illuminate\Support\Facades\Log;

class SalesforceImportChildOpportunityNotificationEvent extends AbstractNotificationEvent
{
    private Member $member;

    public function __construct(private int $memberId, private int $userId)
    {
        Log::info('Import Child Opp');
        $this->member = app(FindMemberByIdTask::class)->run($this->memberId);

        parent::__construct();
    }

    public function getNotification(): string
    {
        $url = sprintf(config('appSection-notification.member_details_printf_url'), config('app.frontend_url'), $this->member->getHashedKey());

        return sprintf("<p>Import Child Opportunity From Salesforce for: <a href='%s'>%s</a> added</p>", $url, $this->member->name);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
