<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnswerController extends ApiController
{
    function __construct(Request $request)
    {
        if( ! $request->input('answer') )
        {
            $this->answer = false;
        }

        $this->answer = $request->input('answer');
    }

    public function checkAnswer($pointN, Request $request)
    {
        // Check code
        if( ! ( $code = $this->getCode($request) ) )
        {
            return $this->response(false, 'Code Error');
        }

        // Check answer
        if( ! $this->answer )
        {
            return $this->response(false, 'Answer field required');
        }

        // Get route
        $route = $code->Route;

        if( ! $route )
        {
            return $this->response(false, 'Route not found');
        }

        // Get point
        $point = $route->getPointByOrder($pointN);

        if( ! $point )
        {
            return $this->response(false, 'Point not found');
        }

        $this->point = $point;

        // Check right answer
        if( ! $this->_check())
        {
            return $this->response(false, 'Answer not found');
        }

        // Save current user point to DB
        //
        $code->point_id = $pointN + 1;
        // If game over, deactivate code
        if($code->Route->countOfPoints() < $code->point_id)
        {
            $code->active = 0;
        }
        $code->save();
        // End save

        return $this->response(true);
    }

    private function _check()
    {
        return $this->point->checkAnswer(trim($this->answer));
    }
}
