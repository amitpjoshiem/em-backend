<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Mails;

use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShareMemberReportMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Media $file, protected string $email)
    {
    }

    public function build(): self
    {
        $view = (new MailMessage())
            ->line('We just generated Report for you')
            ->line('Check attachments to this email')
            ->line(sprintf('File: %s', $this->file->file_name))
            ->render();

        return $this->subject('SWDIRIS Report')->html($view)
            ->to($this->email)
            ->attach($this->file->getTemporaryUrl(now()->addMinute()), [
                'as'   => $this->file->file_name,
                'mime' => 'application/pdf',
            ]);
    }
}
