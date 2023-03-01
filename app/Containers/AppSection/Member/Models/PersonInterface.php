<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Models;

use Carbon\Carbon;

interface PersonInterface
{
    public function getName(): string;

    public function getBirthday(): ?Carbon;

    public function getPhone(): string;

    public function getEmail(): string;

    public function getAge(): ?int;

    public function getUserId(): int;

    /**
     * @psalm-return mixed
     */
    public function getKey();

    /**
     * @psalm-return mixed
     */
    public function getMorphClass();
}
