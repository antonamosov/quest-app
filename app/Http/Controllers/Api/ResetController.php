<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ResetController extends ApiController
{
    public function reset(Request $request)
    {
        ///////////////
        // Get code////
        ///////////////

        if( ! ( $code = $this->getCode($request) ) )
        {
            return $this->response(false);
        }

        // Reset

        $code->point_id = 1;
        $code->active = 1;
        $code->save();

        return $this->response(true);
    }
}
