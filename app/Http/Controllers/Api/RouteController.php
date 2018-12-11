<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

class RouteController extends ApiController
{
    public function route(Request $request)
    {
        if( ! ( $code = $this->getCode($request) ) )
        {
            return $this->response(false);
        }

        if( $code->point_id == 0 )
        {
            $code->point_id = 1;
            $code->save();
        }

        $route = $code->Route;

        if( ! $route )
        {
            return $this->response(false);
        }

        $route->image_path = $this->image($route);

        $route->count_of_points = $route->countOfPoints();

        $route->current_point = (int) $code->point_id;

        return $this->response(true, $route, [
            'name',
            'description',
            'image_path',
            'count_of_points',
            'current_point'
        ]);
    }
}
