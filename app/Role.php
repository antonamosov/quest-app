<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany('App\User', 'role_id', 'id');
    }

    public static function getContributorID()
    {
        return Role::where('name', '=', 'contributor')->first()->id;
    }

    public static function getAdminID()
    {
        return Role::where('name', '=', 'admin')->first()->id;
    }
}
