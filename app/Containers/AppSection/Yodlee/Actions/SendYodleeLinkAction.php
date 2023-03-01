<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Actions;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Yodlee\Data\Transporters\SendYodleeLinkTransporter;
use App\Containers\AppSection\Yodlee\Exceptions\NotFoundMemberYodleeAccountException;
use App\Containers\AppSection\Yodlee\Mails\YodleeLinkMail;
use App\Containers\AppSection\Yodlee\Tasks\SaveYodleeMemberTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendYodleeLinkAction extends Action
{
    public function run(SendYodleeLinkTransporter $input): void
    {
        $member = app(FindMemberByIdTask::class)->run($input->member_id);

        if ($member->yodlee === null) {
            throw new NotFoundMemberYodleeAccountException();
        }

        $link_expired =  now()->addMinutes(config('appSection-yodlee.fastlink_email_ttl'));
        $url          = URL::temporarySignedRoute('web_yodlee_link', $link_expired, ['id' => $member->getHashedKey()]);
        Mail::send((new YodleeLinkMail($url, $member->email))->onQueue('email'));

        if (empty(Mail::failures())) {
            app(SaveYodleeMemberTask::class)->run([
                'link_sent'     => true,
                'link_expired'  => $link_expired,
                'link_used'     => false,
            ], $member->getKey());
        }
    }
}
