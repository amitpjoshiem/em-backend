<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\CLI\Commands;

use App\Containers\AppSection\Media\Models\TemporaryUpload;
use App\Ship\Parents\Commands\ConsoleCommand;

class TemporaryClearCommand extends ConsoleCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apiato:temporary:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean expired uploaded temporary files.';

    /**
     * Execute the console command.
     */
    public function handle(TemporaryUpload $temporaryUpload): void
    {
        /** @psalm-suppress UndefinedMagicMethod */
        $temporaryUpload->whereDate('created_at', '<=', today()->subHours(6))
            ->each(static function (TemporaryUpload $file): void {
                $file->delete();
            });

        $this->info(sprintf("\nThe temporary files has been cleaned successfully. %s", now()->toDateTimeString()));
    }
}
