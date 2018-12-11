<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.09.16
 * Time: 18:03
 */

namespace App;


class StaticMap
{
    private $key = 'AIzaSyCHcocAB-7iu4pl1vSRoYtI2dU3lZYcPSc';

    public $url;

    public function __construct($coordinates)
    {
        $url = 'http://maps.googleapis.com/maps/api/staticmap?';

        $url .= 'zoom=16';
        $url .= '&format=jpg';
        $url .= '&scale=2';
        $url .= '&size=300x200';
        $url .= '&markers=color:blue%7Clabel:S%7C';
        $url .= trim($coordinates);
        $url .= '&' . $this->key;

        $this->url = $url;
    }
}