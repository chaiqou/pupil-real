<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRolesAndPremissions extends Command
{

    protected $signature = 'portal:sync-roles-and-permissions';


    protected $description = 'This command sync DB roles and premissions based on portal-permissions config file';


    public function handle()
    {
        $configPermissions = config('portal-premission.permissions');
        $configRoles = config('portal-premission.roles');

        // Get the roles and permissions from the database
        $dbRoles = Role::pluck('name')->toArray();
        $dbPermissions = Permission::pluck('name')->toArray();

        // Compare roles/permissions from config and also from DB
        $newRoles = array_diff($configRoles, $dbRoles);
        $newPermissions = array_diff($configPermissions, $dbPermissions);

        // Add new roles and permissions
        foreach ($newRoles as $role) {
            Role::create(['name' => $role]);
        }

        foreach ($newPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        $deletedRoles = array_diff($dbRoles, $configRoles);
        $deletedPermissions = array_diff($dbPermissions, $configPermissions);

        // Delete roles and permissions that are not in the config file
        Role::whereIn('name', $deletedRoles)->delete();
        Permission::whereIn('name', $deletedPermissions)->delete();

        $this->info('Roles and permissions updated successfully');


    }
}
