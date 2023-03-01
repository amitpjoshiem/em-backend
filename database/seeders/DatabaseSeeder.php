<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Ship\Core\Loaders\SeederLoaderTrait;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use SeederLoaderTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->runLoadingSeeders();
    }
}
