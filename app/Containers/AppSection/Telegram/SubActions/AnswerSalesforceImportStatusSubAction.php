<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\SubActions;

use App\Containers\AppSection\Salesforce\Tasks\FindAllSalesforceImportsTask;
use App\Ship\Parents\Actions\SubAction;
use Zavrik\LaravelTelegram\Models\TelegramBotUser;

class AnswerSalesforceImportStatusSubAction extends SubAction
{
    /**
     * @throws \Exception
     */
    public function run(TelegramBotUser $telegramUser): void
    {
        $salesforceImports = app(FindAllSalesforceImportsTask::class)->run();

        $html = view('appSection@telegram::salesforce_import', ['imports' => $salesforceImports]);

        $telegramUser->service()->sendHtmlMessage($html->render());
    }
}
