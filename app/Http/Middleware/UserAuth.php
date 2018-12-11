<?php

namespace App\Http\Middleware;

use App\Domain;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

class UserAuth
{
    /**
     * The Guard implementation.
     * @var Guard
     */
    protected $user_auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $user_auth
     */
    public function __construct(Guard $user_auth)
    {
        $this->user_auth = $user_auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        //dd($input);



        if(session('logged'))
        {
            return $next($request);
        }

        if ($this->user_auth->guest()) {

            return redirect()->guest(action('Showcase\AuthController@getLogin'));

        }

        return $next($request);
    }
}
