<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Models;

use App\Containers\AppSection\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

interface DocumentInterface
{
    /** @psalm-suppress MissingReturnType */
    public function getKey();

    public function getDocument(): Media;

    public function advisorSign(Carbon $date): bool;

    public function clientSign(Carbon $date): bool;

    public function updateDocument(UploadedFile $file): void;

    public function updateCertificate(UploadedFile $file): void;

    public function getResourceKey(): string;

    public function isCompleted(): bool;
}
