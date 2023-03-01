<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\UI\CLI\Commands;

use App\Containers\AppSection\Authorization\Actions\SyncPermissionsOnRoleAction;
use App\Containers\AppSection\Authorization\Data\Transporters\SyncPermissionsOnRoleTransporter;
use App\Containers\AppSection\Authorization\Exceptions\GuardNotFoundException;
use App\Containers\AppSection\Authorization\Exceptions\RoleNotFoundException;
use App\Containers\AppSection\Authorization\Tasks\GetAllPermissionsTask;
use App\Ship\Parents\Commands\ConsoleCommand;
use Illuminate\Database\Eloquent\Collection;

class GiveAllPermissionsToRoleCommand extends ConsoleCommand
{
    /** @var string */
    protected $signature = 'apiato:permissions:toRole {role} {guard?}';

    /** @var string */
    protected $description = 'Give all system Permissions to a specific Role and Guard.';

    public function handle(): void
    {
        $roleName = $this->argument('role');

        if (!\is_string($roleName)) {
            throw new RoleNotFoundException('Role name is not found!');
        }

        $guardName = $this->argument('guard') ?? config('auth.defaults.guard');

        if (!\is_string($guardName)) {
            throw new GuardNotFoundException('Guard name is not found!');
        }

        /** @var Collection $allPermissions */
        $allPermissions = app(GetAllPermissionsTask::class)->filterByGuard($guardName)->run(true);

        $allPermissionsNames = $allPermissions->pluck('name')->toArray();

        $transporter = SyncPermissionsOnRoleTransporter::fromArrayable([
            'role_id'         => $roleName,
            'permissions_ids' => $allPermissionsNames,
        ]);

        app(SyncPermissionsOnRoleAction::class)->run($transporter);

        $permissionsString = implode(' - ', $allPermissionsNames);

        $this->info(sprintf('Gave the Role (%s) the following Permissions: %s.', $roleName, $permissionsString));
    }
}
