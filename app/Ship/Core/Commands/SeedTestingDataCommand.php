<?php

namespace App\Ship\Core\Commands;

use App\Ship\Core\Abstracts\Commands\ConsoleCommand;
use Illuminate\Support\Facades\Config;

class SeedTestingDataCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiato:seed-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed testing data.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->call('db:seed', [
            '--class' => Config::get('apiato.seeders.testing'),
        ]);

        $this->info('Testing Data Seeded Successfully.');
    }
}
