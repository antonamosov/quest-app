<?php

namespace App\Http\Controllers\Api;

use App\StaticMap;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PointController extends ApiController
{
    public function currentPoint(Request $request)
    {
        // Get the code
        if( ! ( $code = $this->getCode($request) ) )
        {
            return $this->response(false, 'Code not found.');
        }

        // 0 to 1 for code with point_id == 0
        if( $code->point_id == 0 )
        {
            $code->point_id = 1;
            $code->save();
        }

        // Get point
        $point = $code->getPointByOrder($code->point_id);

        if( ! $point )
        {
            return $this->response(false, 'Point not found.');
        }

        // Image actions
        $point->btw_image_path = $this->image($point);
        $point->question_image_path = $this->questionImage($point);

        // number of max points and current point
        $point->count_of_points = $point->Route->countOfPoints();
        $point->current_point = (int) $code->point_id;

        if( ! $point->Question )
        {
            return $this->response(false, 'Question for this point not found');
        }

        // Hints
        $point->count_of_hints = $point->countOfHints();

        // Map
        $point->coordinates = $this->map($point->coordinates);


        // Question
        $point->question_question = trim($point->Question->question);
        $point->question_paragraph = trim($point->Question->paragraph);

        return $this->response(true, $point, [
            'name',
            'question_image_path',
            'how_to_get',
            'coordinates',
            'btw',
            'btw_image_path',
            'question_question',
            'question_paragraph',
            'count_of_hints',
            'count_of_points',
            'current_point'
        ]);
    }
    /**
     * GET point
     *
     * @param $pointOrder
     * @param Request $request
     * @return mixed
     */
    public function point($pointOrder, Request $request)
    {
        // Get the code
        if( ! ( $code = $this->getCode($request) ) )
        {
            return $this->response(false);
        }

        // Get point
        $point = $code->getPointByOrder($pointOrder);

        if( ! $point )
        {
            return $this->response(false);
        }

        // Image actions
        $point->btw_image_path = $this->image($point);
        $point->question_image_path = $this->questionImage($point);

        if( ! $point->Question )
        {
            return $this->response(false);
        }

        // Hints
        $point->count_of_hints = $point->countOfHints();

        // Map
        $point->coordinates = $this->map($point->coordinates);

        // Question
        $point->question_question = trim($point->Question->question);
        $point->question_paragraph = trim($point->Question->paragraph);

        return $this->response(true, $point, [
            'name',
            'question_image_path',
            'how_to_get',
            'coordinates',
            'btw',
            'btw_image_path',
            'question_question',
            'question_paragraph',
            'count_of_hints'
        ]);
    }

    /**
     * GET all points
     *
     * @param Request $request
     * @return mixed
     */
    public function points(Request $request)
    {
        if( ! ( $code = $this->getCode($request) ) )
        {
            return $this->response(false);
        }

        //dd($code->Route);

        if( ! $code->Route )
        {
            if( ! $code->Route->points )
            {
                return $this->response(false);
            }
        }

        $points = $code->Route->points;

        return $this->responseWithList($points, [
            'name',
            'question_image_path',
            'btw_image_path',
            'how_to_get',
            'coordinates',
            'btw',
            'question_question',
            'question_paragraph',
            'number',
            'count_of_hints'
        ]);
    }

    private function responseWithList( $points, $only)
    {
        $output = [];

        foreach( $points as $point )
        {
            // Image actions
            $point->btw_image_path = $this->image($point);
            $point->question_image_path = $this->questionImage($point);

            if( ! $point->Question )
            {
                return $this->response(false);
            }

            $point->count_of_hints = $point->countOfHints();

            // Map
            $point->coordinates = $this->map($point->coordinates);

            $point->question_question = trim($point->Question->question);
            $point->question_paragraph = trim($point->Question->paragraph);

            $output[] = $this->prepare_response($point, $only);
        }

        return ['success' => true, 'response' => $output];
    }

    public function map($coordinates)
    {
        $map = new StaticMap(str_replace(' ', '', $coordinates));

        return $map->url;
    }
}
