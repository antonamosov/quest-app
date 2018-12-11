<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

class HintController extends ApiController
{
    public function hint($pointN, $hintN, Request $request)
    {
        if( ! ( $code = $this->getCode($request) ) )
        {
            return $this->response(false);
        }

        if( ! $this->checkHintNumber($hintN) )
        {
            return $this->response(false, 'Hint Number error');
        }

        $route = $code->Route;

        if( ! $route )
        {
            return $this->response(false, 'Route not found');
        }

        $point = $route->getPointByOrder($pointN);

        if( ! $point )
        {
            return $this->response(false, 'Point not found');
        }

        $hint = $point->getHintByOrder($hintN);

        if( ! $hint )
        {
            return $this->response(false, 'Hint not found');
        }

        return $this->response(true, $hint, ['name']);
    }

    public function checkHintNumber($number)
    {
        $number = (int) $number;

        if (($number < 4) && ($number > 0))
        {
            return true;
        }
        return false;
    }
}
