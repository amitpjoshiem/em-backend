<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Mails;

use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShareDocReportMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Media $file, protected string $email)
    {
    }

    public function build(): self
    {
        $view = (new MailMessage())
            ->line('We just generated Client Report for you')
            ->line('Check attachments to this email')
            ->line(sprintf('File: %s', $this->file->file_name))
            ->render();

        return $this->html($view)
            ->to($this->email)
            ->attach($this->file->getTemporaryUrl(now()->addMinute()), [
                'as'   => $this->file->file_name,
                'mime' => $this->file->mime_type,
            ]);
    }
}
