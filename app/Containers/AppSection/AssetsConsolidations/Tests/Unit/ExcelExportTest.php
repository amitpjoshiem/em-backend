<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tests\Unit;

use App\Containers\AppSection\AssetsConsolidations\Actions\GenerateExcelExportAction;
use App\Containers\AppSection\AssetsConsolidations\Data\Enums\AssetsConsolidationsExportStatusEnum;
use App\Containers\AppSection\AssetsConsolidations\Data\Enums\AssetsConsolidationsExportTypeEnum;
use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\CreateExportExcelAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CreateAssetsConsolidationsExportTask;
use App\Containers\AppSection\AssetsConsolidations\Tests\TestCase;
use App\Containers\AppSection\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use function app;

/**
 * Class ExcelExportTest.
 *
 * @group AssetsConsolidations
 * @group unit
 */
class ExcelExportTest extends TestCase
{
    /**
     * @test
     */
    public function testExcelExport(): void
    {
        /** @var User $user */
        $user                 = $this->getTestingUser();
        $member               = $this->registerMember($user->getKey());
        $tablesConfig         = config('appSection-assetsConsolidations.export.excel');
        $assetsConsolidations = collect();
        AssetsConsolidationsTable::factory()->count(5)->create([
            'member_id' => $member->getKey(),
        ])->each(function (AssetsConsolidationsTable $table) use (&$assetsConsolidations, $member): void {
            $assetsConsolidations = $assetsConsolidations->merge(AssetsConsolidations::factory()->count(random_int(5, 20))->create([
                'member_id' => $member->getKey(),
                'table_id'  => $table->getKey(),
            ]));
        });
        /** @var Collection $assetsConsolidations */
        $assetsConsolidations = $assetsConsolidations->sortBy('id')->groupBy('table_id');
        $fileName             = 'test.xlsx';
        $exportData           = new CreateExportExcelAssetsConsolidationsTransporter([
            'member_id'  => $member->getKey(),
            'user_id'    => $user->getKey(),
            'type'       => AssetsConsolidationsExportTypeEnum::EXCEL,
            'filename'   => $fileName,
            'status'     => AssetsConsolidationsExportStatusEnum::SUCCESS,
            'created_at' => Carbon::now(),
        ]);
        $export       = app(CreateAssetsConsolidationsExportTask::class)->run($exportData);
        $file         = app(GenerateExcelExportAction::class)->run($export->getKey(), $member->getKey(), $fileName);
        $reader       = IOFactory::createReaderForFile($file)->setReadDataOnly(true)->load($file);
        /** @var Worksheet $worksheet */
        $worksheet    = $reader->getSheetByName('Final SWR');

        $iterator = 0;
        /** @var Collection $tableData */
        foreach ($assetsConsolidations as $tableKey => $tableData) {
            $tableStart = 'A' . ($tableKey * ($tablesConfig['table_rows'] + 6) + 2);

            if ($tableKey === 1) {
                $tableStart = 'A2';
            }

            $firstTableCell = $worksheet->getCell($tableStart);
            $rows           = $worksheet->getRowIterator($firstTableCell->getRow());
            $rows->next();
            for ($i = 0; $i < $tablesConfig['table_rows']; $i++) {
                /** @var AssetsConsolidations | null $currentAssetsAllocation */
                $currentAssetsAllocation = $tableData->get($iterator);

                if ($currentAssetsAllocation === null) {
                    $this->assertEquals($tableData->count(), $i);

                    return;
                }

                foreach ($tablesConfig['columns_alias'] as $fieldName => $column) {
                    $this->assertEquals(
                        $currentAssetsAllocation->{$fieldName},
                        $worksheet->getCell($column . $rows->current()->getRowIndex())->getValue()
                    );
                }

                $iterator++;
                $rows->next();
            }
        }
    }
}
