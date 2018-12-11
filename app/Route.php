<?php

namespace App;

use App\SydneyQuest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class Route extends SydneyQuest
{
    protected $fillable = [
        'name', 'slug', 'description', 'image_id', 'price', 'category_id', 'contributor_id', 'user_id', 'miniature_id', 'popular_category_id', 'update_popular_at'
    ];

    public static function routeIsFree($routeID)
    {
        $route = Route::find($routeID);

        if( ! $route)
        {
            return false;
        }

        if( ! $route->price )
        {
            return true;
        }

        return false;
    }

    public function isFree()
    {
        if( ! $this->price )
        {
            return true;
        }

        return false;
    }

    public function ownRoutes()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return Route::orderBy('id', 'desc')->get();
        }

        if($user->hasRole('admin'))
        {
            return Route::where('user_id', '=', $user->id)->orderBy('id', 'desc')->get();
        }

        if($user->hasRole('contributor'))
        {
            return Route::where('contributor_id', '=', $user->id)->orderBy('id', 'desc')->get();
        }

        return false;
    }


    public function security()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return true;
        }

        if($user->hasRole('contributor'))
        {
            if($this->contributor_id == $user->id)
            {
                return true;
            }
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

    public function Image()
    {
        return $this->belongsTo('App\Image');
    }

    public function Miniature()
    {
        return $this->belongsTo('App\Image', 'miniature_id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Category');
    }

    public function Contributor()
    {
        return $this->belongsTo('App\User');
    }

    public function Admin()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Partner()
    {
        return $this->belongsTo('App\Partner', 'user_id', 'user_id');
    }

    public function Points()
    {
        return $this->hasMany('App\Point');
    }

    public function routesFromCategory($category)
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return Route::where('category_id', '=', $category->id)->get();
        }

        if($user->hasRole('admin'))
        {
            return Route::where('category_id', '=', $category->id)->where('user_id', '=', $user->id)->get();
        }

        if($user->hasRole('contributor'))
        {
            return Route::where('category_id', '=', $category->id)->where('contributor_id', '=', $user->id)->get();
        }

        return false;
    }

    public function inDomain($currentDomain)
    {
        if( $partner = $this->Partner )
        {
            if( $domain = $partner->Domain )
            {
                if( $domain->id == $currentDomain->id )
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function pointsOrder()
    {
        $busyPoints = $this->points;

        $m =  [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35];

        foreach ($busyPoints as $point)
        {
            Unset($m [ $point->number - 1]);
        }

        sort($m);

        if (isset($m[0]))
        {
            return $m[0];
        }
       else
       {
           return 0;
       }

    }

    public function countOfPoints()
    {
        $n = 0;
        if( $this->points )
        {
            foreach( $this->points as $point )
            {
               $n++;
            }
        }
        return $n;
    }

    public function getPointByOrder($order)
    {
        return Point::whereRouteId($this->id)->whereNumber($order)->first();
    }

    /**
     * Check price when saving tour
     * Check max_free
     * Check format
     *
     * @return false if no errors
     * @return @error if check error
     */
    public function checkPrice()
    {
        // Check max free
        if($this->price == 0)
        {
            $partner = Partner::whereUserId($this->user_id)->first();
            if( ! $partner )
            {
                return 'You can\'t create free tour, because you don\'t have a partner';
            }

            if($partner->max_free <= $this->countFreeRoutes())
            {
                // Check existing price != 0
                $route = Route::find($this->id);
                // When create tour
                if(!$route)
                {
                    return 'You have exceed limit of max free routes.';
                }

                if( Route::find($this->id)->price )
                {
                    return 'You have exceed limit of max free routes.';
                }
            }

        }

        if($this->price < 100 && $this->price > 0)
        {
            return 'Price of tour do not be < $0.99.';
        }

        return false;
    }

    public function countFreeRoutes()
    {
        return Route::whereUserId($this->user_id)->wherePrice(0)->count();
    }

    /**
     * Price to numeric (integer) before save to DB
     */
    public function toNumeric($price)
    {
        return $price * 100;
    }

    /**
     * Return price
     */
    public function price()
    {
        return $this->price / 100;
    }

    public static function ownForReport($paginate)
    {
        $user = Auth::user();

        $routes = Route::own()->orderBy('name');

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

    public function Codes()
    {
        return $this->hasMany('App\Code', 'route_id');
    }

    public function CodesWithTrashed()
    {
        return $this->hasMany('App\Code', 'route_id')->withTrashed();
    }

    public function scopeOwn($query)
    {
        $user = Auth::user();

        if($user->hasRole('admin'))
        {
            $query = $query->whereUserId($user->id);
        }

        if($user->hasRole('contributor'))
        {
            return $query->whereContributorId($user->id);
        }

        return $query;
    }

    ////////////////////////////////////////////////////////////////////////////////
    //////////////////////////// REPORT FUNCTIONS //////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    /**
     * Get codes from route for calculations
     *
     * @param $params
     * @return mixed
     */
    public function getCodesForReport($params)
    {
        if($params->pay_system === 'all')
        {
            $params->pay_system = ['pin', 'paypal', 'generated'];
        }

        //dd($params->day);

        $codes = $this->codesWithTrashed
            ->where('paid_at', '>=', $params->day->from)
            ->where('paid_at', '<=', $params->day->to)
            ->whereIn('pay_type', $params->pay_system);

        if(Auth::user()->hasRole('admin'))
        {
            $codes = $codes->where('user_id', '=', Auth::user()->id);
        }

        return $codes;
    }

    /**
     * Get codes from routes for total calculations
     *
     * @param $params
     * @return mixed
     */
    public function getAllCodesForReport($params)
    {
        if($params->pay_system === 'all')
        {
            $params->pay_system = ['pin', 'paypal', 'generated'];
        }

        foreach($this->get() as $route)
        {
            $codes = $route->codesWithTrashed
                ->where('paid_at', '>=', $params->day->from)
                ->where('paid_at', '<=', $params->day->to)
                ->whereIn('pay_type', $params->pay_system);

            if(Auth::user()->hasRole('admin'))
            {
                $codes = $codes->where('user_id', '=', Auth::user()->id);
            }

            if(isset($newCodes))
            {
                $codes = $newCodes->merge($codes);
            }

            $newCodes = $codes;
        }

        //dd($codes);

        return $codes;
    }

    public function sum($params)
    {
        $sum = 0;
        //dd($params->day);

        $codes = $this->getCodesForReport($params);

        //dd($codes);

        foreach($codes as $code)
        {
            //echo $code->price();
            $sum += $code->price();
        }

        return round($sum / 100, 2);
    }



    public function commission($params)
    {
        $commission = 0;

        $codes = $this->getCodesForReport($params);

        //dd($codes);

        foreach($codes as $code)
        {
           $price = $code->price();
           $commission += ( $price / 100 * $code->Partner->percent );
        }

        return round($commission / 100, 2);
    }

    public function total($params)
    {
        $total = 0;

        $codes = $this->getCodesForReport($params);

        foreach($codes as $code)
        {
            $price = $code->price();
            $total += ( $price - $price / 100 * $code->Partner->percent );
        }

        return round($total / 100, 2);
    }

    public function total_sum($params)
    {
        $total_sum = 0;

        $codes = $this->getAllCodesForReport($params);

        foreach($codes as $code)
        {
            $total_sum += $code->price();
        }

        return round($total_sum / 100, 2);
    }

    public function total_commission($params)
    {
        $total_commission = 0;

        $codes = $this->getAllCodesForReport($params);

        foreach($codes as $code)
        {
            $price = $code->price();
            $total_commission += ( $price / 100 * $code->Partner->percent );
        }

        return round($total_commission / 100, 2);
    }

    public function total_total($params)
    {
        $total_commission = 0;

        $codes = $this->getAllCodesForReport($params);

        foreach($codes as $code)
        {
            $price = $code->price();
            $total_commission += ( $price - $price / 100 * $code->Partner->percent );
        }

        return round($total_commission / 100, 2);
    }



    public function scopeDate($query, $day)
    {
        return $query->where('update_at', '>', $day->from)->where('update_at', '<', $day->to);
    }

    public static function searchRoutes($filter)
    {
        $routes = Route::where('name', 'like', '%' . $filter . '%');
        if(Auth::user()->hasRole('admin'))
        {
            $routes = $routes->whereUserId(Auth::user()->id);
        }
        return $routes->get();
    }

    public function domainName()
    {
        if($partner = $this->Partner)
        {
            if($domain = $partner->Domain)
            {
                return $domain->slug;
            }
        }

        return '';
    }

    public function shortName()
    {
        if(iconv_strlen($this->name) > 27)
        {
            return mb_substr($this->name, 0, 27) . '...';
        }

        return $this->name;
    }

    public function hasPoints()
    {
        if($points = $this->points)
        {
            if(count($points))
            {
                return true;
            }
        }
        return false;
    }

    public function miniaturePath()
    {
        if($image = $this->Miniature)
        {
            return $image->path;
        }
        return '';
    }

    public function imagePath()
    {
        if($image = $this->Image)
        {
            return $image->path;
        }
        return '';
    }

    public static function setPopular($count)
    {
        $codes = Code::whereActive(1)->get();

        // Update (clear) old popular codes
        $tomorrow = Carbon::now()->subDay();
        $routes = Route::wherePopularCategoryId(1)                              // Get old most popular for set to zero this field
            ->where('update_popular_at', '<', $tomorrow->format('Y-m-d H:i:s')) // Check date update
            ->get();
        foreach($routes as $route) {
            $route->update(['popular_category_id' => 0]);
        }

        $routes = Route::get();
        $routeArr = [];
        $routeArr[] = 0;

        // Generate array for routes ids
        foreach($routes as $route)
        {
            while(!isset($routeArr[$route->id]))
            {
                $routeArr[] = 0;
            }
        }

        $maxRouteID = count($routeArr);

        // Calc routes most popular
        foreach($codes as $code)
        {
            $routeArr[$code->route_id]++;
        }

        // Unset zeros elements from array
        foreach($routeArr as $array_key=>$array_item)
        {
            if($routeArr[$array_key] == 0)
            {
                unset($routeArr[$array_key]);
            }
        }

        // Generate array with most popular route_id ( value => route_id )
        $arrSkipIndex = [];

        for($k = 0; $k < $count; $k++)
        {
            for($i = 0, $curMaxVal = 0, $curMaxIndex = 0; $i < $maxRouteID; $i++)
            {
                if(isset($routeArr[$i]))
                {
                    // skip used indexes
                    $skip = 0;
                    for($j = 0; $j < count($arrSkipIndex); $j++)
                    {
                        if($arrSkipIndex[$j] == $i)
                        {
                            $skip = 1;
                        }
                    }
                    if($routeArr[$i] > $curMaxVal and !$skip)
                    {
                        $curMaxIndex = $i;
                        $curMaxVal = $routeArr[$i];
                    }
                }
            }
            $arrSkipIndex[] = $curMaxIndex;
        }

        $arrRouteIndex = $arrSkipIndex;

        $routes = Route::whereIn('id', $arrRouteIndex)->get();
        foreach($routes as $route) {
            $route->update(['popular_category_id' => 1, 'update_popular_at' => Carbon::now()]);
        }
        return $routes;
    }

    /**
     * GET url with domain route placed
     *
     * @return string
     */
    public function url()
    {
        return 'http://' . $this->domainName() . '.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN');
    }

    /**
     * Check duplicate popular tour for landing
     *
     * @return bool
     */
    public function duplicateWithPopular()
    {
        if($this->isPopular())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isPopular()
    {
        $popularCategory = Category::find(1);
        $popularRoutes = $popularCategory->popularRoutes;
        foreach($popularRoutes as $routes)
        {
            if($routes->id == $this->id)
            {
                return true;
            }
        }
        return false;
    }
}
