<?php

namespace App\Http\Controllers\Api;

use App\Code;
use App\Image;
use App\StaticMap;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    /**
     * Get code from request
     *
     * @param $request
     * @return mixed
     */
    public function getCode($request)
    {
        $codeName = preg_replace('/\t/', '', $request->input('code'));
        return Code::whereName(trim($codeName))->first();
    }

    /**
     * Get code error form request
     *
     * @param $request
     * @return bool|string
     */
    public function getCodeError($request)
    {
        /*
         * 001 - No found code;
         * 002 - No code in request;
         * 003 - Not found active code;
         * 004 - no points for play;
         * 006 - no questions;
         * 007 - Code is old;
         * 008 - The code has not been paid
         */

        $code = Code::whereName(trim($request->input('code')))->first();

        // 001
        //
        if( ! $code )
        {
            $error = '001';
        }

        // 002
        //
        elseif( ! trim($request->input('code')) )
        {
            // No codes in request
            $error = '002';
        }

        // Check 008 (not paid)
        elseif( ! $code->paid() )
        {
            //$this->updateSession($code);
            $error = '008';
        }

        // 004
        //
        elseif( ! ( $point = $code->getPointByOrder($code->point_id) ) )
        {
            $error = '004';
        }

        // 006
        //
        elseif( ! ( $point->Question ) )
        {
            $error = '006';
        }

        // 003
        //
        elseif( ! $code->active )
        {
            // Deactivated code
            $error = '003';
        }

        // 007 and other
        //
        else
        {
            if($code->old())
            {
                // The code is old
                $error = '007';
            }
            else
            {
                // No errors
                return false;
            }
        }

        return $error;
    }

    /**
     * Prepare response for output
     *
     * @param $success
     * @param null $response
     * @param null $only
     * @return mixed
     */
    public function response($success, $response = NULL, $only = NULL)
    {
        $output['success'] = $success;

        if( $response )
        {
            if( ! $success )
            {
                $output['error'] = $response;
                return $output;
            }

            $r = $response->toArray();

            $output['response'] = array_only($r, $only);
        }

        //return $output;

        return Response::json($output);
    }

    /**
     * Get error description by error code
     *
     * @param string $code
     * @param object or NULL $Code
     * @return string
     */
    public function getMessageError($code, $Code)
    {
        $codeName = ( $Code ? $Code->name : '' );
        $paidUrlShow = 'http://play.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN') . '/get_payment';
        $paidUrl = $paidUrlShow . '?code=' . $codeName;

        $errors = (object) [
            '001' => 'The code is not found',
            '002' => 'No code in request',
            '003' => 'The code is not found',
            '004' => "The Quest " . $this->getRouteNameForErrorOutput($Code) . " has been completed with this code",
            '005' => "The Quest " . $this->getRouteNameForErrorOutput($Code) . " is deleted",
            '006' => 'Cannot find the question',
            '007' => 'The code is outdated',
            '008' => 'This code is not active because the selected quest has not been paid.<br>Please click on this URL to proceed with the payment<br><a href="'. $paidUrl .'">'. $paidUrlShow .'</a>',
        ];

        foreach($errors as $error => $msg)
        {
            if($error === $code)
            {
                return $msg;
            }
        }

        return 'Error';
    }

    /**
     * Get Route Name from code
     *
     * @param $code
     * @return string
     */
    public function getRouteNameForErrorOutput($code)
    {
        if($code)
        {
            if($code->Route)
            {
                return $code->Route->name;
            }
        }

        return '';
    }

    /**
     * Return image path from object
     *
     * @param $obj
     * @return string
     */
    public function image($obj)
    {
        if( $obj->Image )
        {
            return $obj->Image->path;
        }

        return '';
    }

    /**
     * Return question image path from object
     *
     * @param $obj
     * @return string
     */
    public function questionImage($obj)
    {
        if( $obj->Question )
        {
            if( $obj->Question->Image )
            {
                return $obj->Question->Image->path;
            }
        }

        return '';
    }

    /**
     * Prepare response for Point Controller
     *
     * @param $obj
     * @param $only
     * @return array
     */
    public function prepare_response($obj, $only)
    {
        $r = $obj->toArray();

        return array_only($r, $only);
    }

    /**
     * Get map url from coordinates
     *
     * @param $coordinates
     * @return string
     */
    public function map($coordinates)
    {
        $map = new StaticMap(str_replace(' ', '', $coordinates));

        return $map->url;
    }

    public function updateSession($code)
    {
        //session(['route' => $code->Route->id, 'code_id' => $code->id]);
        //dd(session('code_id'));
    }
}
