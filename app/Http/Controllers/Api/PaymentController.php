<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentController extends ApiController
{
    public function checkSuccess(Request $request)
    {
        ///////////////
        // Get code////
        ///////////////

        $code = $this->getCode($request);

        ////////////////
        // Check code //
        ////////////////

        if(!$code)
        {
            return $this->response(false);
        }

        if($code->active && $code->paid_at)
        {
            $success = true;
        }
        else
        {
            $success = false;
        }

        return $this->response($success);
    }
}
