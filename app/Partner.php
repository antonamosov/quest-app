<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Partner extends Model
{
    protected $fillable = [
        'name', 'domain_id', 'user_id', 'max_free', 'percent'
    ];

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function Admin()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Domain()
    {
        return $this->belongsTo('App\Domain');
    }

    public function Categories()
    {
        return $this->hasMany('App\Category', 'user_id', 'user_id');
    }

    public function Routes()
    {
        return $this->hasMany('App\Route', 'user_id', 'user_id');
    }

    public function Codes()
    {
        return $this->hasMany('App\Code', 'user_id', 'user_id');
    }

    public function CodesWithTrashed()
    {
        return $this->hasMany('App\Code', 'user_id', 'user_id')->withTrashed();
    }

    ////////////////////////////////////////////////////////////////////////////////
    //////////////////////////// REPORT FUNCTIONS //////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    public static function forReport($paginate)
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            $routes = Partner::orderBy('name');
            if($paginate)
            {
                $routes = $routes->paginate($paginate);
            }
            else
            {
                $routes = $routes->get();
            }
        }

        return $routes;
    }

    public function sum($params)
    {
        $sum = 0;

        $routes = $this->routes;

        foreach($routes as $route)
        {
            $sum += $route->sum($params);
        }

        return $sum;
    }

    public function commission($params)
    {
        $commission = 0;

        $routes = $this->routes;

        foreach($routes as $route)
        {
            $commission += $route->commission($params);
        }

        return $commission;
    }

    public function total($params)
    {
        $total = 0;

        $routes = $this->routes;

        foreach($routes as $route)
        {
            $total += $route->total($params);
        }

        return $total;
    }

    public function total_sum($params)
    {
        $route = $this->first()->routes->first();

        return $route->total_sum($params);
    }

    public function total_commission($params)
    {
        $route = $this->first()->routes->first();

        return $route->total_commission($params);
    }

    public function total_total($params)
    {
        $route =$this->first()->routes->first();

        return $route->total_total($params);
    }

    public static function searchPartners($filter)
    {
        $partners = Partner::where('name', 'like', '%' . $filter . '%');
        if(Auth::user()->hasRole('admin'))
        {
            $partners = $partners->whereUserId(Auth::user()->id);
        }

        return $partners->get();
    }

    public function landingCategories()
    {
        $categories = Category::join('routes', 'routes.category_id', '=', 'categories.id')
            ->select('categories.*')
            ->where('routes.user_id', '=', $this->user_id)
            ->get()
            ->unique();

        return $categories;
    }
}
