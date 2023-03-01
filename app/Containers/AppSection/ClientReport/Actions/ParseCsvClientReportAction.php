<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\ClientReport\Exceptions\CsvValidationException;
use App\Containers\AppSection\ClientReport\Mails\CsvErrorsReportMail;
use App\Containers\AppSection\ClientReport\Tasks\CreateClientReportByCsvDataTask;
use App\Containers\AppSection\ClientReport\Tasks\ValidateClientReportRowTask;
use App\Containers\AppSection\Member\Data\Repositories\MemberRepository;
use App\Ship\Parents\Actions\Action;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParseCsvClientReportAction extends Action
{
    public function __construct(protected Csv $reader, private MemberRepository $memberRepository)
    {
    }

    public function run(string $file): void
    {
        $tmpFile = 'temp.csv';
        /** @var FilesystemAdapter $tmpStorage */
        $tmpStorage = Storage::disk('temp');
        $tmpStorage->put($tmpFile, Storage::disk('sftp')->get($file));

        $temp        = $tmpStorage->path($tmpFile);
        $sheet       = $this->reader->load($temp);
        $worksheet   = $sheet->getActiveSheet();
        $header      = $this->parseHeader($worksheet);
        $rowIterator = $worksheet->getRowIterator(2);

        DB::beginTransaction();
        $errors = [];
        foreach ($rowIterator as $row) {
            $cellIterator = $row->getCellIterator();
            $rowData      = [];
            /** @var Cell $cell */
            foreach ($cellIterator as $cell) {
                $columnName           = $header[$cell->getColumn()];
                $rowData[$columnName] = $cell->getValue();
            }

            try {
                $memberId = app(ValidateClientReportRowTask::class)->run($rowData);
                app(CreateClientReportByCsvDataTask::class)->run($rowData, $memberId);
            } catch (CsvValidationException $csvValidationException) {
                $errors[$row->getRowIndex()] = $csvValidationException->getMessage();
            }
        }

        if (empty($errors)) {
            DB::commit();
        } else {
            DB::rollBack();
            $adminEmail = config('appSection-clientReport.admin_email');
            Mail::send((new CsvErrorsReportMail($errors, $adminEmail, $temp, basename($file)))->onQueue('email'));
        }

        Storage::disk('temp')->delete($tmpFile);
    }

    private function parseHeader(Worksheet $worksheet): array
    {
        $rowIterator = $worksheet->getRowIterator();
        $row         = $rowIterator->current();

        $header = [];
        /** @var Cell $cell */
        foreach ($row->getCellIterator() as $cell) {
            $header[$cell->getColumn()] = $cell->getValue();
        }

        return $header;
    }
}
