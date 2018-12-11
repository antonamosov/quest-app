<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{
    protected $fillable = [
        'name', 'paragraph', 'question', 'user_id', 'image_id'
    ];

    public function ownQuestions()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return Question::get();
        }

        if($user->hasRole('admin'))
        {
            return $user->questions;
        }

        if($user->hasRole('contributor'))
        {
            return $user->contributor_questions;
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
        return $this->hasOne('App\Point');
    }

    public function Image()
    {
        return $this->belongsTo('App\Image');
    }


}
