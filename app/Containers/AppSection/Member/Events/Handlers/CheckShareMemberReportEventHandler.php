<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Events\Handlers;

use App\Containers\AppSection\Activity\Events\Events\SharedPDFToEvent;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Containers\AppSection\Media\Tasks\FindMediaByModelTask;
use App\Containers\AppSection\Media\Tasks\GetAllTemporaryUploadByUuidsTask;
use App\Containers\AppSection\Member\Events\Events\ShareMemberReportEvent;
use App\Containers\AppSection\Member\Mails\ShareMemberReportMail;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\CreateMemberReportTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CheckShareMemberReportEventHandler implements ShouldQueue
{
    public ?string $queue = 'documents';

    public function handle(ShareMemberReportEvent $event): void
    {
        /** @var TemporaryUpload $report */
        $report = app(GetAllTemporaryUploadByUuidsTask::class)->run($event->uuids)->first();
        /** @var User $user */
        $user = app(FindUserByIdTask::class)->run($event->userId);
        /** @var Media $media */
        $media       = app(FindMediaByModelTask::class)->run($report, MediaCollectionEnum::MEMBER_REPORT);
        $emails      = $this->filterEmails($event->emails);
        $wrongEmails = array_diff($event->emails, $emails);
        foreach ($emails as $key => $email) {
            Mail::send((new ShareMemberReportMail($media, $email))->onQueue('email'));

            if (Mail::failures()) {
                $wrongEmails[] = $email;
                unset($emails[$key]);
            }
        }

        $memberReport = app(CreateMemberReportTask::class)->run([
            'user_id'           => $user->getKey(),
            'success_emails'    => $emails,
            'error_emails'      => array_values($wrongEmails),
            'file_id'           => $report->getKey(),
        ]);

        event(new SharedPDFToEvent($user->getKey(), $memberReport->getKey()));
    }

    private function filterEmails(array $emails): array
    {
        /** Filter emails that we don`t have in or DB(users, members, spouses) */
        $userEmails   = User::query()->whereIn('email', $emails)->get(['email'])->pluck('email');
        $memberEmails = Member::query()->whereIn('email', $emails)->get(['email'])->pluck('email');
        $spouseEmails = MemberContact::query()->whereIn('email', $emails)->get(['email'])->pluck('email');
        $emails       = $userEmails->merge($memberEmails)->merge($spouseEmails)->unique();

        return $emails->toArray();
    }
}
