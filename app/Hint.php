<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Hint extends Model
{
    protected $fillable = [
        'name', 'question_id', 'user_id', 'point_id'
    ];

    public function ownHints()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return Hint::get();
        }

        if($user->hasRole('admin'))
        {
            return $user->hints;
        }

        if($user->hasRole('contributor'))
        {
            return $user->contributor_hints;
        }

        return false;
    }

    public function security()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return true;
        }

        if($user->hasRole('admin'))
        {
            if($this->user_id == $user->id)
            {
                return true;
            }
        }

        if($user->hasRole('contributor'))
        {
            if($this->user_id == $user->partner_id)
            {
                return true;
            }
        }

        return false;
    }

    public function Route()
    {
        return $this->belongsTo('App\Route');
    }

    public function setAdmin($input)
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return $input['admin_id'];
        }

        if($user->hasRole('admin'))
        {
            return $user->id;
        }

        if($user->hasRole('contributor'))
        {
            return $user->getContributorAdmin()->id;
        }

        return 0;
    }

    public function Point()
    {
        return $this->belongsTo('App\Point');
    }

    public function Question()
    {
        return $this->belongsTo('App\Question');
    }
}
