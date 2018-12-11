<?php

namespace App\Http\Controllers\Showcase;

use App\Domain;
use App\Route;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    public function index($routeID)
    {
        $route = Route::find($routeID);
        $domain = Domain::where('slug', '=', '.')->first();

        if ( ! $route)
        {
            return 'Page not found';
        }

        //dd($route);

        if ( ! $route->inDomain($domain))
        {
            return 'Page not found';
        }

        return view('showcase.route.page', ['route' => $route, 'domain' => $domain]);
    }

    public function domainIndex($domain, $routeID)
    {
        $route = Route::find($routeID);
        $domain = Domain::where('slug', '=', $domain)->first();

        if ( ! $route)
        {
            return 'Page not found';
        }

        if ( ! $route->inDomain($domain))
        {
            return 'Page not found';
        }

        $landing = $domain->Landing;

        if($landing)
        {
            return view('showcase.route.partner_page', ['route' => $route, 'domain' => $domain, 'landing' => $landing]);
        }

        return view('showcase.route.page', ['route' => $route, 'domain' => $domain]);
    }
}
