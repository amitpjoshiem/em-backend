<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\Events\Events;

class ClientReportDocGeneratedEvent extends AbstractNotificationEvent
{
    public function __construct(
        private int $userId,
        private string $hashedMemberId,
        private string $status,
        private string $hashedDocId
    ) {
        parent::__construct();
    }

    public function getNotification(): string
    {
        $url = config('app.frontend_url') . sprintf(config('appSection-clientReport.client_report_docs_front_url'), $this->hashedMemberId, $this->hashedDocId);

        return sprintf('<p>Your <a href="%s">Client Report Doc</a> export finished with status: %s</p>', $url, $this->status);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getNeedUpdate(): ?string
    {
        return 'client_report_pdf_export';
    }

    public function getAdditionData(): array
    {
        return [
            'member_id' => $this->hashedMemberId,
        ];
    }
}
