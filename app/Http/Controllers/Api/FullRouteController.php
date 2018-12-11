<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FullRouteController extends ApiController
{
    public function route(Request $request)
    {
        ///////////////
        // Get code////
        ///////////////

        $code = $this->getCode($request);

        //dd($code);

        // Update  point_id if zero
        if($code)
        {
            if( $code->point_id == 0 )
            {
                $code->point_id = 1;
            }
            $code->save();
        }

        // Get route for getMessageError() and others
        if($code)
        {
            $route = $code->Route;

            if( ! $route )
            {
                // error output before all error output, because getMessageError function need Route Name
                return $this->response(false, ['code' => '005', 'message' => 'The Quest Route is deleted']);
            }
        }

        // Check code for errors
        if( $codeError = $this->GetCodeError($request) )
        {
            $msgError = $this->getMessageError($codeError, $code);

            return $this->response(false, ['code' => $codeError, 'message' => $msgError]);
        }

        ////////////////
        // Get route ///
        ////////////////

        $route->image_path = $this->image($route);

        $route->count_of_points = $route->countOfPoints();

        $route->current_point = (int) $code->point_id;

        $route->route_name = $route->name;

        /////////////////
        // Get point ///
        ///////////////

        $point = $code->getPointByOrder($code->point_id);

        // Image actions
        $route->btw_image_path = $this->image($point) ? $this->image($point) : false;
        $route->question_image_path = $this->questionImage($point) ? $this->questionImage($point) : false;

        // Map
        $map = $point->getMap();
        $route->coordinates =  $map ? $map : false;

        // Question
        $route->question_name = trim($point->name);
        $route->question_question = trim($point->Question->question);
        $route->question_paragraph = trim($point->Question->paragraph) ? trim($point->Question->paragraph) : false;

        $route->btw = trim($point->btw) ? trim($point->btw) : false;
        $route->how_to_get = trim($point->how_to_get) ? trim($point->how_to_get) : false;

        /////////////////
        // Get hints ///
        ///////////////

        $route->hints_01 = $point->getHintByOrder(1) ? $point->getHintByOrder(1)->name : false;
        $route->hints_02 = $point->getHintByOrder(2) ? $point->getHintByOrder(2)->name : false;
        $route->hints_03 = $point->getHintByOrder(3) ? $point->getHintByOrder(3)->name : false;

        ///////////////////////////////////
        // Correct answer (first answer) //
        ///////////////////////////////////

        $route->correct_answer = $point->answers->first()->name;

        ///////////////////////////////////
        ////// Partner domain name ////////
        ///////////////////////////////////

        $route->partner_nickname = $route->domainName();

        // Return response

        return $this->response(true, $route, [
            'route_name',
            'count_of_points',
            'current_point',
            'how_to_get',
            'coordinates',
            'question_name',
            'question_question',
            'question_paragraph',
            'question_image_path',
            'hints_01',
            'hints_02',
            'hints_03',
            'correct_answer',
            'btw',
            'btw_image_path',
            'partner_nickname'
        ]);
    }
}
