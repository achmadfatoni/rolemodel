<?php

namespace Klsandbox\RoleModel;

use Klsandbox\SiteModel\Site;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property integer $site_id
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $friendly_name
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role whereSiteId($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role whereFriendlyName($value)
 * @mixin \Eloquent
 */
class Role extends Model {

    use \Klsandbox\SiteModel\SiteExtensions;

    protected $table = 'roles';
    public $timestamps = true;

    public function users() {
        return $this->hasMany('App\Models\User');
    }

    public static function findByName($roleName) {
        return Role::forSite()->where(['name' => strtolower($roleName)])->first();
    }

    public static function __callStatic($method, $parameters) {
        static $cachedRoles = null;
        if (is_null($cachedRoles)) {
            $cachedRoles = array_values(\Config::get('role.roles'));
        }

        if (in_array($method, $cachedRoles)) {
            return Role::findByName($method);
        }

        return parent::__callStatic($method, $parameters);
    }

}
