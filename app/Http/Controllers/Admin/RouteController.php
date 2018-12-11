<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Image;
use App\Point;
use App\Route;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    public function getList(Route $route)
    {
        $routes = $route->ownRoutes();

        return view('admin.route.list')->withRoutes($routes);
    }

    public function getListFromCategory(Category $category, Route $route)
    {
        $routes = $route->routesFromCategory($category);

        return view('admin.route.list', ['routes' => $routes, 'category' => $category]);
    }

    public function edit(Route $route, Category $category, Request $request)
    {
        $categories = $category->notVirtual()->get();
        $contributors = Auth::user()->getContributors();
        $points = Point::whereRouteId($route->id);

        // Change points sort
        if($request->sort === 'asc')
        {
            $points = $points->OrderBy('number', 'asc')->get();
        }
        else
        {
            $points = $points->OrderBy('number', 'desc')->get();
        }

        //dd($request->getQueryString());

        return view('admin.route.edit', [
            'route' => $route,
            'categories' => $categories,
            'contributors' => $contributors,
            'points' => $points,
            'currentQueryString' => $request->getQueryString()
        ]);
    }

    public function update($routeID, Request $request, Image $image)
    {
        $input = $request->all();

        $miniatureSize = [
            'width' => 630,
            'height' => 400
        ];

        $imageSize = [
            'width' => 1062,
            'height' => NULL
        ];

        $input = $image->formActionRoute($input, $imageSize, $miniatureSize);

        $route = Route::find($routeID);


        if( ! $route->security())
        {
            return redirect()->back()->withErr('You can not edit this tour.');
        }

        $input['price'] = $route->price = $route->toNumeric($input['price']);

        if( $priceError = $route->checkPrice() )
        {
            return redirect()->back()->withErr($priceError);
        }

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $route->update($input);

        // Show modal for create point
        if( ! $route->hasPoints() )
        {
            $request->session()->flash('modalErr', 'myModal_POI_create');
        }

        return redirect()->back()->withMsg('Saved successful');
    }

    public function create(Category $category)
    {
        $currentUser = Auth::user();
        $categories = $category->notVirtual()->get();
        $contributors = $currentUser->getContributors();

        return view('admin.route.create', ['categories' => $categories, 'contributors' => $contributors]);
    }

    public function store(Request $request, Image $image)
    {
        $input = $request->all();

        $miniatureSize = [
            'width' => 630,
            'height' => 400
        ];

        $imageSize = [
            'width' => 1062,
            'height' => NULL
        ];

        $input = $image->formActionRoute($input, $imageSize, $miniatureSize);

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $route = new Route($input);

        if(Auth::user()->hasRole('global'))
        {
            $route->user_id = $route->Category->user_id;
        }
        if(Auth::user()->hasRole('admin'))
        {
            $route->user_id = Auth::user()->id;
        }

        $route->price = $route->toNumeric($input['price']);

        //dd($route);

        if( $priceError = $route->checkPrice() )
        {
            return redirect()->back()->withErr($priceError);
        }

        $route->save();

        // Show modal for create point
        $request->session()->flash('modalErr', 'myModal_POI_create');

        return redirect()->to('/admin/route/edit/' . $route->id)->withMsg('Saved successful');
    }

    public function destroy(Route $route)
    {
        if ( ! $route->security())
        {
            redirect()->back()->withErr('You can not delete this route.');
        }

        $route->delete();

        return redirect()->route('admin.route.list')->withMsg('Deleted successful');
    }

    private function validator($input)
    {
        $validator = Validator::make( $input, [
            'name'          => 'required',
            'image_id'      => 'required',
            'price'         => 'numeric|required',
            'category_id'   => 'required',
        ]);

        if($validator->fails())
        {
            return $validator;
        }
        else
        {
            return false;
        }
    }
}
