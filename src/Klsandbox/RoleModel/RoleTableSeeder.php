<?php

namespace Klsandbox\RoleModel;

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        $roles = \Config::get('role.roles');
        foreach ($roles as $roleName => $roleFriendlyName) {
            $role = Role::where('name', '=', $roleName)->first();
            if (!$role) {
                $role = Role::create(['name' => $roleName,
                    'friendly_name' => $roleFriendlyName, ]);
                $role->save();
            }
        }
    }
}
