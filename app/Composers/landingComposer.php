<?php namespace App\Composers;

class LandingComposer
{

    public function compose($view)
    {
        //Add your variables
        $view->with('menuList', (object) config('menu'))
            ->with('currentUrl', 'http://' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN'))
            ->with('currentSlag', '/');
    }
}