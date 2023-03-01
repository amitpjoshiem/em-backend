<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Actions;

use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\Contacts\GetAllContactsTask;
use App\Containers\AppSection\Member\Tasks\Contacts\UpdateContactTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class MigrateContactsNameAction extends Action
{
    public function run(): void
    {
        /** @var Collection $contacts */
        $contacts = app(GetAllContactsTask::class)->run(true);

        /** @var MemberContact $contact */
        foreach ($contacts as $contact) {
            /** @psalm-suppress UndefinedMagicPropertyFetch */
            $names = $this->splitName($contact->name);
            app(UpdateContactTask::class)->run([
                'first_name' => $names[0],
                'last_name'  => $names[1],
            ], $contact->getKey());
        }
    }

    private function splitName(string $name): array
    {
        $name       = trim($name);
        $last_name  = (str_contains($name, ' ')) ? preg_replace('#.*\s([\w-]*)$#', '$1', $name) : '';
        $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));

        return [$first_name, $last_name];
    }
}
