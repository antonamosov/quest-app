<?php

namespace App\Http\Controllers\Showcase;

use App\Code;
use App\Http\Middleware\UserAuth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function getLogin(Request $request)
    {
        return view('showcase.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make( $request->all(), [
                'code' => 'required'
        ]);

        if( $validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        //dd($request->input('code'));

        $code = Code::where('name', '=', $request->input('code'))->first();

        if ( ! $code)
        {
            return redirect()->back()->withErr('Code not found');
        }

        if ( ! $code->active)
        {
            return redirect()->back()->withErr('Code not found');
        }

        return redirect()->route('play.main');
    }

    public function getLogout()
    {
        session(['logged' => 0]);

        return redirect()->route('play.main');
    }
}
