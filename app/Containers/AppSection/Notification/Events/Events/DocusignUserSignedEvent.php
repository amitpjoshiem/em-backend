<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Events;

class DocusignUserSignedEvent extends AbstractNotificationEvent
{
    public function __construct(private int $userId, private string $memberId, private string $signedUser, private string $type, private string $fixedAnnuityIndexId)
    {
        parent::__construct();
    }

    public function getNotification(): string
    {
        $url = sprintf('%s/advisor/member/%s/annuity-index-details/%s', config('app.frontend_url'), $this->memberId, $this->fixedAnnuityIndexId);

        return sprintf('<p>User %s sign Document <a href="%s">%s</a></p>', $this->signedUser, $url, $this->type);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getNeedUpdate(): ?string
    {
        return 'fixed_annuities_index';
    }
}
