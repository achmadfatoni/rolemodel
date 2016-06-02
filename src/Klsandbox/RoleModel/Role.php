<?php

namespace Klsandbox\RoleModel;

use Illuminate\Database\Eloquent\Model;
use Klsandbox\SiteModel\Site;

/**
 * App\Models\Role
 *
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role Admin()
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role Staff()
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role Stockist()
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role Dropship()
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\RoleModel\Role Sales()
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
class Role extends Model
{
    use \Klsandbox\SiteModel\SiteExtensions;

    protected $table = 'roles';
    public $timestamps = true;

    private static $cache;

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public static function findByName($roleName)
    {
        $roleName = strtolower($roleName);

        if (!self::$cache) {
            self::$cache = [];
        }

        if (!key_exists(Site::id(), self::$cache)) {
            self::$cache[Site::id()] = [];
        }

        if (key_exists($roleName, self::$cache[Site::id()])) {
            return self::$cache[Site::id()][$roleName];
        }

        $item = self::forSite()->where(['name' => $roleName])->first();
        assert($item, $roleName);

        self::$cache[Site::id()][$roleName] = $item;

        return $item;
    }

    public static function __callStatic($method, $parameters)
    {
        static $cachedRoles = null;
        if (is_null($cachedRoles)) {
            $cachedRoles = array_values(\Config::get('role.roles'));
        }

        if (in_array($method, $cachedRoles)) {
            return self::findByName($method);
        }

        return parent::__callStatic($method, $parameters);
    }
}
