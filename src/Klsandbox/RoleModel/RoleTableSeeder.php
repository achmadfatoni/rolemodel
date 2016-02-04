<?php

namespace Klsandbox\RoleModel;

use Illuminate\Database\Seeder;
use Klsandbox\RoleModel\Role;
use Klsandbox\SiteModel\Site;

class RoleTableSeeder extends Seeder {

    public function run() {
        $roles = \Config::get('role.roles');

        foreach (Site::all() as $site) {
            Site::setSite($site);
            foreach ($roles as $roleName => $roleFriendlyName) {
                $role = Role::firstOrNew(array(
                    'name' => $roleName,
                    'friendly_name' => $roleFriendlyName
                ));

                $role->save();
            }
        }
    }

}
