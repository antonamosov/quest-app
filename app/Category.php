<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    protected $fillable = [
        'name', 'description', 'image_id', 'user_id'
    ];


    public function Routes()
    {
        return $this->hasMany('App\Route');
    }

    public function popularRoutes()
    {
        return $this->hasMany('App\Route', 'popular_category_id');
    }

    public function Partner()
    {
        return $this->belongsTo('App\Partner', 'user_id', 'user_id');
    }

    public function Codes()
    {
        return $this->hasManyThrough('App\Code', 'App\Route');
    }

    public function CodesWithTrashed()
    {
        return $this->hasManyThrough('App\Code', 'App\Route')->withTrashed();
    }

    public function security()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return true;
        }

        if($user->hasRole('admin'))
        {
            if($this->user_id == $user->id)
            {
                return true;
            }
        }

        return false;
    }

    public function scopeNotVirtual($query)
    {
        return $query->whereIsVirtual(NULL);
    }

    public function ownCategories()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return Category::notVirtual()->get();
        }

        if($user->hasRole('admin'))
        {
            return Category::notVirtual()->where('user_id', '=', $user->id)->get();
        }

        if($user->hasRole('contributor'))
        {
            $myAdmin = User::find($user->partner_id);

            return Category::notVirtual()->where('user_id', '=', $myAdmin->id)->get();
        }

        return false;
    }

    public function scopeOwn($query)
    {
        $user = Auth::user();

        if($user->hasRole('admin'))
        {
            $query = $query->whereUserId($user->id);
        }

        return $query;
    }


    ////////////////////////////////////////////////////////////////////////////////
    //////////////////////////// REPORT FUNCTIONS //////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    public static function ownForReport($paginate)
    {
        $routes = Category::notVirtual()->orderBy('name');

        if($paginate)
        {
            $routes = $routes->paginate($paginate);
        }
        else
        {
            $routes = $routes->get();
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

        return $route ? $route->total_sum($params) : 0;
    }

    public function total_commission($params)
    {
        $route = $this->first()->routes->first();

        return $route ? $route->total_commission($params) : 0;
    }

    public function total_total($params)
    {
        $route = $this->first()->routes->first();

        return $route ? $route->total_total($params) : 0;
    }

    public static function searchCategories($filter)
    {
        $categories = Category::where('name', 'like', '%' . $filter . '%');

        return $categories->get();
    }


    public function getAll()
    {
        return Category::notVirtual()->get();
    }

    /**
     * Get all categories with popular for main landing
     *
     * @param $countPopular
     * @return mixed
     */
    public function getAllWithPopular($countPopular)
    {
        Route::setPopular($countPopular);
        $categories = Category::get();
        /*$routesIDs = [];
        foreach($categories as $category)
        {
            if($category->id == 1)
            {
                foreach($category->popularRoutes as $route)
                {
                    $routesIDs[] = $route->id;
                }
            }
            else
            {
                foreach($category->Routes as $route)
                {
                    for($i = 0; $i < count($routesIDs); $i++)
                    {
                        if($route->id == $routesIDs[$i])
                        {
                            $route->no_show = 1;
                            break;
                        }
                    }
                }
            }
        }*/
        return $categories;
    }
}
