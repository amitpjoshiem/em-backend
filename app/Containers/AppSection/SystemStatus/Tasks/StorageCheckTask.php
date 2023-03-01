<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Tasks;

use App\Containers\AppSection\SystemStatus\Exceptions\StorageFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageCheckTask extends Task
{
    /**
     * @psalm-return true
     */
    public function run(): bool
    {
        if (!config('systemstatus-container.services.storage')) {
            return true;
        }

        $uniqueString = Str::random(64);
        $corrupted    = [];

        $disks = config('systemstatus-container.storage.disks');

        if (empty($disks) || !\is_array($disks)) {
            throw new StorageFailedException();
        }

        foreach ($disks as $disk) {
            try {
                $storage = Storage::disk($disk);

                $storage->put($uniqueString, $uniqueString);

                $contents = $storage->get($uniqueString);

                $storage->delete($uniqueString);

                if ($contents !== $uniqueString) {
                    $corrupted[] = $disk;
                    continue;
                }
            } catch (Exception $exception) {
                throw new StorageFailedException(previous: $exception);
            }
        }

        if (!empty($corrupted)) {
            $corrupted = implode(', ', $corrupted);
            throw new StorageFailedException(sprintf('Some storage disks are not working: %s', $corrupted));
        }

        return true;
    }
}
