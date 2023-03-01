<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Notifications;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param User|mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback !== null) {
            return \call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $mail = $notifiable->getEmailForPasswordReset();
        $url  = config('apiato.frontend.url') . config('user-container.allowed-reset-password-url') . sprintf('?email=%s&token=%s', $mail, $this->token);

        return $this->buildMailMessage($url);
    }
}
