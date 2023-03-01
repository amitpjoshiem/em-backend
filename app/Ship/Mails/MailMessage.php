<?php

namespace App\Ship\Mails;

use Illuminate\Notifications\Messages\MailMessage as BaseMailMessage;
use Illuminate\Support\HtmlString;

class MailMessage extends BaseMailMessage
{
    public function plate(...$lines): static
    {
        $view = view('vendor/mail/html/plate', [
            'lines' => $lines,
        ]);

        $this->line(new HtmlString($view->toHtml()));

        return $this;
    }

    public function code(string $code): static
    {
        $view = view('vendor/mail/html/code', [
            'code' => $code,
        ]);

        $this->line(new HtmlString($view->toHtml()));

        return $this;
    }

    /**
     * @param string $text
     * @param string $url
     * @param bool $isAction
     * @param string|null $style
     * @return $this
     */
    public function button(string $text, string $url, bool $isAction = false, string $style = null): static
    {
        $view = view('vendor/mail/html/button', [
            'slot' => $text,
            'url' => $url,
            'style' => $style,
        ]);

        if ($isAction) {
            $this->actionText = $text;
            $this->actionUrl = $url;
        }

        $this->line(new HtmlString($view->toHtml()));

        return $this;
    }
}
