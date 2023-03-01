<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Actions;

use App\Containers\AppSection\Telegram\Data\Enums\TelegramKeyboardEnum;
use App\Containers\AppSection\Telegram\SubActions\AnswerOnEntryCommandSubAction;
use App\Containers\AppSection\Telegram\SubActions\AnswerSalesforceImportStatusSubAction;
use App\Containers\AppSection\Telegram\Tasks\SendMainKeyboardTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Zavrik\LaravelTelegram\InputMessages\AbstractMessage;
use Zavrik\LaravelTelegram\InputMessages\TextMessage;
use Zavrik\LaravelTelegram\Models\TelegramBot;

class AnswerTelegramAction extends Action
{
    public function run(array $message): void
    {
        $bot           = TelegramBot::getByName(config('appSection-telegram.telegram_bot_name'));
        $messageObject = AbstractMessage::parseMessage($message);

        try {
            $telegramUser = $bot->service()->getUserByTelegramId($messageObject->getCompanionId());
        } catch (ModelNotFoundException) {
            $telegramUser = $bot->service()->createUser($messageObject->getCompanionId());
        }

        if ($telegramUser->user === null) {
            app(AnswerOnEntryCommandSubAction::class)->run($telegramUser);

            return;
        }

        if ($messageObject instanceof TextMessage) {
            if ($messageObject->getMessageText() === TelegramKeyboardEnum::SALESFORCE_IMPORT_STATUS) {
                app(AnswerSalesforceImportStatusSubAction::class)->run($telegramUser);

                return;
            }

            app(SendMainKeyboardTask::class)->run($telegramUser);
        }
    }
}
