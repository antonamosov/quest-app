<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DocumentationController extends Controller
{
    public function index()
    {
        $url = 'http://play.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN') . '/';

        return view('api.doc')->withUrl($url);
    }
}
