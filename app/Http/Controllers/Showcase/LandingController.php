<?php

namespace App\Http\Controllers\Showcase;

use App\Category;
use App\Domain;
use App\Route;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class LandingController extends Controller
{
    /**
     * GET main landing
     *
     * @param $category
     * @param Route $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Category $category, Route $route)
    {
        $domain = Domain::where('slug', '=', '.')->first();

        if ( ! $domain )
        {
             abort(404);
        }

        return view('showcase.landing', [
            'categories' => $category->getAllWithPopular(5),
            'domain'     => $domain
        ]);
    }

    /**
     * GET landing for partner
     *
     * @param $domainSlug
     * @param Category $category
     * @param Route $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getLanding($domainSlug, Category $category, Route $route)
    {
        $domain = Domain::where('slug', '=', $domainSlug)->first();

        if ( ! $domain )
        {
            // abort(404);
            return redirect()->to('http://' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN'));
        }

        //dd($domain->Partner);

        if($partner = $domain->Partner)
        {
            $categories = $partner->landingCategories();
            //dd($categories);
        }
        else
        {
            $categories = false;
        }

        //dd($categories);

        $landing = $domain->Landing;

        // Get menu
        //$menuList = (object) config('menu');
        //$currentUrl = 'http://' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN');

        // Column variable
        $columnVariable = $landing->setColumnVariable();

        if( ! $landing)
        {
            return view('showcase.landing', [
                'categories' => $category->getAllWithPopular(5),
                'routes' => $route->popular(5),
                'domain' => $domain,
                'landing' => $landing,
                'columnVariable' => $columnVariable,
                //'menuList'   => $menuList,
                //'currentUrl' => $currentUrl,
                //'currentSlag'=> '/'
            ]);
        }

        /*if ( ! $landing->checkFields() )
        {
            return view('showcase.landing', [
                'categories' => $categories,
                'domain' => $domain,
                'landing' => $landing,
                'columnVariable' => $columnVariable
            ]);
        }*/

        return view('showcase.partner.landing', [
            'categories' => $categories,
            'domain' => $domain,
            'landing' => $landing,
            'columnVariable' => $columnVariable
        ]);
    }

    /**
     * GET info page
     *
     * @param $slag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getInfoPage($slag)
    {
        $menuList = (object) config('menu');
        $currentUrl = 'http://' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN');

        foreach($menuList as $menuName => $menu)
        {
            if($menu['slag'] == $slag) {
                $template        = $menu['template'];
                $title           = $menu['title'];
                break;
            }
        }

        if(!isset($template) or !isset($title))
        {
            abort(404);
        }

        return view('showcase.info.' . $template, [
            'title'           => $title,
            'menuList'        => $menuList,
            'currentUrl'      => $currentUrl,
            'currentSlag'     => $slag
        ]);
    }
}


