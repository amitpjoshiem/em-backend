<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Sms\Notifications;

use App\Ship\Core\Abstracts\Notifications\Notification;
use NotificationChannels\AwsSns\SnsChannel;
use NotificationChannels\AwsSns\SnsMessage;

class SmsNotification extends Notification
{
    public function __construct(protected string $text)
    {
    }

    public function via(mixed $notifiable): array
    {
        return [SnsChannel::class];
    }

    public function toSns(): SnsMessage
    {
        return SnsMessage::create([
            'body'      => $this->text,
            'sender'    => config('app.name'),
        ]);
    }
}
