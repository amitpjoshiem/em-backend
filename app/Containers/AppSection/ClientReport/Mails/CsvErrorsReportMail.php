<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Mails;

use App\Ship\Mails\MailMessage;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Testing\MimeType;
use Illuminate\Support\HtmlString;

class CsvErrorsReportMail extends Mail implements ShouldQueue
{
    use Queueable;

    public function __construct(protected array $errors, protected string $email, protected string $file, protected string $fileName)
    {
    }

    public function build(): self
    {
        $errorLines = [];
        foreach ($this->errors as $row => $error) {
            $errorLines[] = new HtmlString(sprintf('<div style="padding: 10px 5px; border-bottom: 1px solid lightgray"><span style="font-weight: 600; color: #1f2628;">Line #%s<span>: <span style="color: #c13f4b;">%s</span></div>', $row, $error));
        }

        $view = (new MailMessage())
            ->error()
            ->line('You have some errors in parsed CSV File')
            ->line(new HtmlString(sprintf('<div style="padding: 10px 5px; border-bottom: 1px solid lightgray;"><span style="font-weight: 600;  color: #1f2628;">File:</span> <span style="font-weight: 500;">%s</span></div>', $this->fileName)))
            ->lines($errorLines)
            ->render();

        return $this
            ->subject('CSV Parse Error')
            ->html($view)
            ->attach($this->file, [
                'as'   => $this->fileName,
                'mime' => MimeType::get(pathinfo($this->fileName, PATHINFO_EXTENSION)),
            ])
            ->to($this->email);
    }
}
