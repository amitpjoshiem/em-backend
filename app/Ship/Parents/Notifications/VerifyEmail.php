<?php

namespace App\Ship\Parents\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailLaravelNotification;

class VerifyEmail extends VerifyEmailLaravelNotification
{
    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return config('notification.channels');
    }
}
