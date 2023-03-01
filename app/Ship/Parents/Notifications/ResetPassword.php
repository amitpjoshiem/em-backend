<?php

namespace App\Ship\Parents\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordLaravelNotification;

class ResetPassword extends ResetPasswordLaravelNotification
{
    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return config('notification.channels');
    }
}
