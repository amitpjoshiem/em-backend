<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Events\Events;

use App\Containers\AppSection\Media\Tasks\FindMediaByIdTask;
use App\Containers\AppSection\Member\Tasks\FindMemberReportByIdTask;
use Faker\Generator;

class SharedPDFToEvent extends AbstractActivityEvent
{
    public function __construct(int $userId, int $memberReportId)
    {
        $memberReport = app(FindMemberReportByIdTask::class)->run($memberReportId);
        parent::__construct($userId, [
            'shared_emails' => $memberReport->success_emails,
            'error_emails'  => $memberReport->error_emails,
            'file_id'       => $memberReport->file->getKey(),
        ]);
    }

    public static function getActivityHtmlString(array $data): string
    {
        $media  = app(FindMediaByIdTask::class)->run($data['file_id']);
        $url    = $media->getTemporaryUrl(now()->addMinutes(30));
        $emails = implode(',', $data['shared_emails']);

        return sprintf("<p>You have shared <a href='%s'>Progress Report</a> to %s</p>", $url, $emails);
    }

    /**
     * This activity we don`t seed because if we don`t have a file it will make an Error.
     */
    public static function seedActivity(Generator $faker, int $userId): array
    {
        return [];
    }
}
