<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    private $openRoutes = ['ipn_action', 'listener'];

    public function handle($request, Closure $next)
    {
        //add this condition
        foreach($this->openRoutes as $route) {

            if ($request->is($route))
            {
                return $next($request);
            }
        }

        return parent::handle($request, $next);
    }
}
