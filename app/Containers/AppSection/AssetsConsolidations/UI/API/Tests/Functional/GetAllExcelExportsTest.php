<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\AssetsConsolidations\Tests\Traits\ExcelFileUploaderTestTrait;
use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class GetAllExcelExportsTest extends ApiTestCase
{
    use ExcelFileUploaderTestTrait;

    private const EXAMPLE_RESPONSE_ARRAY = [
        'id'            => 'kq58xdlrm6wrba39',
        'filename'      => '097ec1e6-3914-493e-86a5-31e2333e38dc.xlsx',
        'status'        => 'success',
        'type'          => 'excel',
        'member_id'     => 'kq58xdlrm6wrba39',
        'member_name'   => 'Myrna Pacocha',
        'created_at'    => '2021-11-23T15:33:10.000000Z',
        'media'         => [
            'object'        => 'Media',
            'id'            => 'kq58xdlrm6wrba39',
            'url'           => 'http://localhost/storage/local/excel_export/1/097ec1e6-3914-493e-86a5-31e2333e38dc.xlsx',
            'name'          => '097ec1e6-3914-493e-86a5-31e2333e38dc',
            'file_name'     => '097ec1e6-3914-493e-86a5-31e2333e38dc.xlsx',
            'extension'     => 'xlsx',
            'conversions'   => [],
            'links'         => [
                'delete'    => [
                    'href'      => '/media/kq58xdlrm6wrba39',
                    'method'    => 'DELETE',
                ],
            ],
        ],
    ];

    protected string $endpoint = 'get@v1/assets_consolidations/{member_id}/export/excel';

    /**
     * @test
     */
    public function testGetAllExcelExportsEmpty(): void
    {
        /** @var User $user */
        $user   = $this->getTestingUser();
        $member = $this->registerMember($user->getKey());

        $fileCount = 5;
        $this->generateExcelExportsFile($user->getKey(), $member->getKey(), $fileCount);
        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertCount($fileCount, $data);
        foreach ($data as $file) {
            $this->assertEmpty(array_diff_key(self::EXAMPLE_RESPONSE_ARRAY, $file));
        }
    }
}
