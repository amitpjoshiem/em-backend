<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Mails;

use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;

class YodleeLinkMail extends Mail
{
    public function __construct(protected string $link, protected string $email)
    {
    }

    public function build(): self
    {
        $view = (new MailMessage())
            ->line('You need to connect Your bank accounts with Yodlee')
            ->line('To give view access of Your bank accounts')
            ->button('Link Yodlee', $this->link)
            ->render();

        return $this->html($view)
            ->to($this->email);
    }
}
