<?php

namespace App;

use Composer\DependencyResolver\SolverProblemsException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Point extends Model
{
    protected $fillable = [
        'route_id', 'number', 'coordinates', 'question_name', 'question_paragraph', 'question_question',
        'btw', 'answer_id', 'hint_id', 'image_id', 'how_to_get', 'question_id', 'map_image_id'
    ];

    public function Image()
    {
        return $this->belongsTo('App\Image');
    }

    public function Route()
    {
        return $this->belongsTo('App\Route');
    }

    public function Question()
    {
        return $this->belongsTo('App\Question');
    }

    public function Answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function Hints()
    {
        return $this->hasMany('App\Hint');
    }

    public function getQuestion()
    {
        return Question::find($this->question_id);
    }

    public function getQuestionName()
    {
        if($question = $this->getQuestion())
            return $question->question;
        return '';
    }

    public function getQuestionParagraph()
    {
        if($question = $this->getQuestion())
            return $question->paragraph;
        return '';
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
            if($user->id == $this->Route->user_id)
            {
                return true;
            }
        }

        if($user->hasRole('contributor'))
        {
            if($user->partner_id == $this->Route->user_id)
            {
                return true;
            }
        }

        return false;
    }

    public function ownPoints()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return Point::get();
        }

        if($user->hasRole('admin'))
        {
            return $user->points;
        }

        if($user->hasRole('contributor'))
        {
            return $user->contributor_points;
        }

        return false;
    }

    public function moveUp()
    {
        $upPoint = Point::whereRouteId($this->route_id)->whereNumber($this->number + 1)->first();

        if ( ! $upPoint)
        {
            return 'Point is last in route.';
        }

        $upPoint->number = $this->number;

        $this->number ++ ;

        $this->save();
        $upPoint->save();

        return false;
    }

    public function moveDown()
    {
        $downPoint = Point::whereRouteId($this->route_id)->whereNumber($this->number - 1)->first();

        if ( ! $downPoint)
        {
            return 'Point is first in route.';
        }

        $downPoint->number = $this->number;

        $this->number -- ;

        $this->save();
        $downPoint->save();

        return false;
    }

    public function getHintByOrder($number)
    {
        if($hints = $this->hints)
        {
            $n = 1;
                foreach( $hints as $hint )
                {
                    if($n == $number)
                    {
                        return $hint;
                    }
                    $n++;
                }
        }

        return false;
    }

    public function countOfHints()
    {
        $n = 0;
        if($hints = $this->hints)
        {
            foreach( $hints as $hint )
            {
                $n++;
            }
        }

        return $n;
    }

    public function checkAnswer($check)
    {
        foreach( $this->answers as $answer)
        {
            if( strnatcasecmp(trim($answer->name), $check) == 0 )
            {
                return true;
            }
        }
        return false;
    }

    public static function pointExist($codeName, $pointN)
    {

    }

    public function staticMap()
    {
        return $this->belongsTo('App\Image', 'map_image_id');
    }

    public function getMap()
    {
        if( ! $this->staticMap )
        {
            $image = new Image;
            $this->map_image_id = $image->getMap($this->coordinates, $this->Route->id, $this->id);

            if($this->map_image_id)
            {
                $this->update();
                $map = Image::find($this->map_image_id);
                if($map)
                    return $map->path;
            }
            return false;
        }
        else
        {
            return $this->staticMap->path;
        }
    }

}
