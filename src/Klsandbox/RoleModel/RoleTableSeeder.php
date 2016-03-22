<?php

namespace Klsandbox\RoleModel;

use Illuminate\Database\Seeder;
use Klsandbox\SiteModel\Site;

class RoleTableSeeder extends Seeder
{

    public function run()
    {
        $roles = \Config::get('role.roles');

        foreach (Site::all() as $site) {
            Site::setSite($site);
            foreach ($roles as $roleName => $roleFriendlyName) {

                $role = Role::forSite()->where('name', '=', $roleName);
                if (!$role) {
                    Role::create(['name' => $roleName,
                        'friendly_name' => $roleFriendlyName]);
                    $role->save();
                }
            }
        }
    }

}
