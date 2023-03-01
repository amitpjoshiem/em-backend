<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\Models;

interface RecipientInterface
{
    /** @psalm-suppress MissingReturnType */
    public function getKey();

    public function getEmail(): string;

    public function getName(): string;
}
