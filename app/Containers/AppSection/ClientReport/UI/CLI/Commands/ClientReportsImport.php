<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\UI\CLI\Commands;

use App\Containers\AppSection\ClientReport\Actions\ParseCsvClientReportAction;
use App\Ship\Parents\Commands\ConsoleCommand;
use Illuminate\Support\Facades\Storage;

class ClientReportsImport extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client_report:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        $directory          = config('appSection-clientReport.import_directory');
        $processedDirectory = config('appSection-clientReport.import_processed_directory');
        $storage            = Storage::disk('sftp');
        $files              = $storage->files($directory);

        if (!$storage->exists($processedDirectory)) {
            $storage->makeDirectory($processedDirectory);
        }

        foreach ($files as $file) {
            app(ParseCsvClientReportAction::class)->run($file);
            $filename  = basename($file);
            $movedFile = sprintf('%s/%s_%s', $processedDirectory, now()->timestamp, $filename);
            $storage->move($file, $movedFile);
        }
    }
}
