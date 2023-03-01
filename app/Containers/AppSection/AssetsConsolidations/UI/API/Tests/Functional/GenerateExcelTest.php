<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\AssetsConsolidations\Events\Events\GenerateExcelExportEvent;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

class GenerateExcelTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/assets_consolidations/{member_id}/export/excel';

    /**
     * @test
     */
    public function testGenerateExcel(): void
    {
        Storage::fake('s3');
        Event::fake();
        /** @var User $user */
        $user   = $this->getTestingUser();
        $member = $this->registerMember($user->getKey());
        AssetsConsolidations::factory()->count(10)->create([
            'member_id' => $member->getKey(),
        ]);
        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        Event::assertDispatched(GenerateExcelExportEvent::class);
    }
}
