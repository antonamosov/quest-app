<?php

namespace App\Http\Controllers\Showcase;

use App\Code;
use App\Domain;
use App\Route;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * play.domain/quest/redirect?code=codeName || play.domain/quest/redirect?route_id=routeID
     *
     * Redirect to register form and set session with codeID
     * Or redirect to game, if code free
     *
     * @param $request (Code name)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function getRedirectTo(Request $request)
    {
        if( ! ( $request->code or $request->route_id ) ) {
            return 'Where are you from?';
        }

        // ??? Redirect to Check code form or game (from email)
        if( $request->code ) {
            $codeName = preg_replace('/\t/', '', $request->code);
            $code = Code::whereName(trim($codeName))->first();
            if( ! $code ) {
                return 'Where are you from?';
            }
            if( $code->free() ) {
                session(['codeName' => $code->name, 'checkCode' => true]);
                return redirect()->route('play.game')->withMsg('The code is free');
            }
            session(['codeID' => $code->id]);
            $code->sendEmailOrPhone();
            return redirect()->route('play.check.form');
        }

        // Redirect to Register form (from landing)
        if( $request->route_id ) {
            $route = Route::find($request->route_id);
            if( ! $route ) {
                return 'Where are you from?';
            }
            session(['routeID' => $route->id]);
            return redirect()->route('play.register.form');
        }
    }

    /**
     * GET Registration form (step 1)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function getRegister()
    {
        if($routeID = session('routeID'))
        {
            $route = Route::find($routeID);
            if(!$route) {
                return 'Where are you from?';
            }
        }
        else {
            return 'Where are you from?';
        }

        return view('showcase.auth.register')->withRoute($route);
    }

    /**
     * POST register
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'email',
            'phone' => 'numeric',
            'code' => 'sometimes',
            'phone_code' => 'sometimes'
        ]);

        /*
         * Code entered
         */
        if( $request->code ) {
            $code = Code::whereName($request->code)->first();
            if( ! $code ) {
                return redirect()->back()->withErr('Wrong code. Please enter the correct code');
            }
            if( $code->paid_at || $code->free() ) {
                session(['codeName' => $code->name, 'checkCode' => true]);
                return redirect()->route('play.game');
            }
            else
            {
                session(['codeID' => $code->id]);
                return redirect()->route('play.get_payment.form');
            }
        }

        /*
         * Email or phone entered
         */

        if( ! isset($input['email']) || ! isset($input['phone']) )
        {
            $validator->getMessageBag()->add('fields', 'Enter the email or phone.');
        }

        if ($validator->fails())
        {
           return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if(! ($routeID = session('routeID') )) {
            return 'Where are you from?';
        }
        if( ! ($route = Route::find($routeID)) ) {
            return 'Where are you from?';
        }


        $code = new Code;

        $code->name = $code->getUniqueCode();
        $code->name_crypt = bcrypt($code->name);
        $code->user_id = $route->user_id;
        $code->route_id = $route->id;
        $code->payment_id = 0;
        $code->active = 0;
        $code->point_id = 0;
        $code->email_or_phone = $request->email ? $request->email : $request->phone_code . ltrim($request->phone, '0');
        $code->type = $request->email ? 'email' : 'phone';
        $code->pay_type = 'not_paid';

        $code->sendEmailOrPhone('first');

        $code->save();

        //dd($code);

        session(['codeID' => $code->id]);

        if( $code->free() ) {
            $code->update(['active' => 1]);
            session(['codeName' => $code->name, 'checkCode' => true]);
            return redirect()->route('play.game')->withMsg('The Code is free');
        }

        // Redirect to the game after get code
        return redirect()->route('play.check.form');
    }
}
