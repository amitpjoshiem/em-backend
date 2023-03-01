<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\UI\API\Tests\Functional;

use App\Containers\AppSection\Activity\Events\Events\AbstractActivityEvent;
use App\Containers\AppSection\Activity\Models\UserActivity;
use App\Containers\AppSection\Activity\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Collection;

/**
 * Class GetAllInitTest.
 *
 * @group init
 * @group api
 */
class GetAllActivityTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/activities?limit=0';

    protected array $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testGetAllActivity(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $this->registerMember($user->getKey());

        /** @var Collection $activities */
        $activities = UserActivity::factory()->count(20)->create([
            'user_id'   => $user->getKey(),
        ])->sortBy('created_at', descending: true)->values();
        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $data  = $content['data'];
//        foreach ($data as $key => $activity)
//        {
//            /** @var UserActivity $baseActivity */
//            $baseActivity = $activities->get($key);
//            /** @var AbstractActivityEvent $class */
//            $class = $baseActivity->activity;
//            dump($baseActivity->toArray(), $activity);
//            $this->assertEquals($class::getActivityHtmlString($baseActivity->activity_data), $activity['content']);
//            $this->assertEquals($baseActivity->created_at->toTimeString() ,$activity['time']);
//            $this->assertEquals($baseActivity->created_at->toDateString() ,$activity['date']);
//
//        }
    }
}
