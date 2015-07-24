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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereSiteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereFriendlyName($value)
 */
class Role extends Model {

    use \Klsandbox\SiteModel\SiteExtensions;

    protected $table = 'roles';
    public $timestamps = true;

    public function users() {
        return $this->hasMany('App\Models\User');
    }

    public static function findByName($roleName) {
        return Role::firstByAttributes(['name' => $roleName, 'site_id' => Site::id()]);
    }

    public static function __callStatic($method, $parameters) {
        if (in_array($method, ['Stockist', 'Admin'])) {
            return Role::firstByAttributes(['name' => $method, 'site_id' => Site::id()]);
        }

        return parent::__callStatic($method, $parameters);
    }

}
