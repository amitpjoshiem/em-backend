<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Tests\Unit;

use App\Containers\AppSection\Member\Events\Events\CreateMemberEvent;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Salesforce\Events\Handlers\CheckMemberCreateEventHandler;
use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Containers\AppSection\Salesforce\Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

/**
 * Class CalculateTotalTest.
 *
 * @group AssetsConsolidations
 * @group unit
 */
class MemberCreateTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateMember(): void
    {
        $user   = $this->getTestingUser();
        SalesforceUser::factory()->create(['user_id' => $user->getKey()]);
        $member = $this->registerMember($user->getKey());
        $event  = new CreateMemberEvent($member);
        /** @var CheckMemberCreateEventHandler $handler */
        $handler = app(CheckMemberCreateEventHandler::class);
        $handler->handle($event);
        /** @var Member $member */
        $member = Member::with(['salesforce', 'salesforce.contact', 'salesforce.opportunity', 'spouse'])->find($member->getKey());
        Http::assertSent(function (Request $request) use ($member) {
            if ($request->url() === $this->loginUrl) {
                return $this->assertAuthSendRequest($request);
            }

            if (str_contains($request->url(), 'sobjects')) {
                $baseData = [];
                preg_match("#.*\/sobjects\/(.*)\/#", $request->url(), $object);

                switch ($object[1]) {
                    case 'Account':
                        $baseData = [
                            'Name'                      => $member->name,
                            'Client_Email_Primary__c'   => $member->email,
                            'Phone'                     => $member->phone,
                            'Type'                      => $member->type,
                            'BillingStreet'             => $member->address,
                            'BillingState'              => $member->state,
                            'BillingCity'               => $member->city,
                            'BillingCountry'            => 'USA',
                            'BillingPostalCode'         => $member->zip,
                        ];
                        break;
                    case 'Contact':
                        $baseData = [
                            'LastName'  => $member->spouse->name,
                            'Title'     => '',
                            'Phone'     => $member->spouse->phone,
                            'AccountId' => $member->salesforce->salesforce_id,
                            'Email'     => $member->spouse->email,
                            'Birthdate' => $member->spouse->birthday->format('Y-m-d'),
                        ];
                        break;
                    case 'Opportunity':
                        $baseData = [
                            'AccountId' => $member->salesforce->salesforce_id,
                            'Name'      => $member->name,
                            'CloseDate' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                            'StageName' => 'Prospect',
                        ];
                        break;
                }

                $this->assertEmpty(array_diff($baseData, $request->data()));

                return true;
            }
        });
    }
}
