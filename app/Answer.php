<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Answer extends Model
{
    protected $fillable = [
        'name', 'question_id', 'point_id'
    ];

    public function ownAnswers()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return Answer::get();
        }

        if($user->hasRole('admin'))
        {
            return $user->answers;
        }

        if($user->hasRole('contributor'))
        {
            return $user->contributor_answers;
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

    public function Question()
    {
        return $this->belongsTo('App\Question');
    }
}
