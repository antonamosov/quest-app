<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'last_name', 'partner_id', 'role', 'first_name', 'image_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /*public function hasRole($role)
    {
        if($this->role === $role)
        {
            return true;
        }
        else
        {
            return false;
        }
    }*/

    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();
        // Check if the user is a root account

        if($this->have_role->name == 'Root')
        {
            return true;
        }

        if(is_array($roles))
        {
            foreach($roles as $need_role)
            {
                if($this->checkIfUserHasRole($need_role))
                {
                    return true;
                }
            }
        } else
        {
            return $this->checkIfUserHasRole($roles);
        }

        return false;
    }

    private function getUserRole()
    {
        return $this->role()->getResults();
    }

    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role)==strtolower($this->have_role->name)) ? true : false;
    }

    public function getContributors()
    {
        $roleID = Role::getContributorID();

        if($this->hasRole('global'))
        {
            return User::where('role_id', '=', $roleID)->get();
        }

        if($this->hasRole('admin'))
        {
            return User::where('role_id', '=', $roleID)->where('partner_id', '=', $this->id)->get();
        }

        return false;
    }


    public function getAdmins()
    {
        $roleID = Role::getAdminID();

        if($this->hasRole('global'))
        {
            return User::where('role_id', '=', $roleID)->get();
        }

        return false;
    }

    /**
     * Get Name of contributor's admin
     *
     * @return mixed
     */
    public function getContributorAdmin()
    {
        $admin = User::find($this->partner_id);

        if($admin)
        {
            return $admin;
        }
        else
        {
            return '';
        }
    }

    /**
     * Get contributor's admin
     *
     * @return mixed
     */
    public function getContributorAdminName()
    {
        $admin = User::find($this->partner_id);

        if($admin)
        {
            return $admin->name;
        }

        return '';
    }

    public function security()
    {
        $user = Auth::user();

        if ($user->hasRole('global'))
        {
            return true;
        }

        if ($user->hasRole('admin'))
        {
            // contributor deleting associated with admin (current user)
            if($this->partner_id == $user->id)
            {
                return true;
            }
        }

        if ($user->hasRole('contributor'))
        {
            // contributor can't delete contributor
            return false;
        }

        return false;
    }

    /**
     * Admin's routes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Routes()
    {
        return $this->hasMany('App\Route', 'user_id');
    }

    /**
     * Contributor's routes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contributor_routes()
    {
        return $this->hasMany('App\Route', 'contributor_id');
    }

    /**
     * Admin's points
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Points()
    {
        return $this->hasManyThrough('App\Point', 'App\Route', 'user_id');
    }

    /**
     * Contributor's points
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Contributor_points()
    {
        return $this->hasManyThrough('App\Point', 'App\Route', 'contributor_id');
    }

    /**
     * Admin's questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Questions()
    {
        return $this->hasMany('App\Question');
    }

    /**
     * Contributor's questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contributor_questions()
    {
        return $this->hasMany('App\Question', 'user_id', 'partner_id');
    }

    /**
     * Admin's hints
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Hints()
    {
        return $this->hasMany('App\Hint');
    }

    /**
     * Contributor's hints
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contributor_hints()
    {
        return $this->hasMany('App\Hint', 'user_id', 'partner_id');
    }

    /**
     * Admin's answers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Answers()
    {
        return $this->hasMany('App\Answer');
    }

    /**
     * Contributor's answers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contributor_answers()
    {
        return $this->hasMany('App\Answer', 'user_id', 'partner_id');
    }

    /**
     * Admin's codess
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Codes()
    {
        return $this->hasManyThrough('App\Code', 'App\Route', 'user_id');
    }

    /**
     * Contributor's codes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contributor_codes()
    {
        return $this->hasManyThrough('App\Code', 'App\Route', 'contributor_id');
    }

    public function landingId()
    {
        if($partner = $this->Partner)
        {
            if($domain = $partner->Domain)
            {
                if($landing = $domain->Landing)
                {
                    return $landing->id;
                }
            }
        }
        return false;
    }

    public function Partner()
    {
        return $this->hasOne('App\Partner');
    }

}


