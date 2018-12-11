<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('admin') or Auth::user()->hasRole('contributor'))
        {
            return redirect()->to('/admin/route');
        }
        return view('admin.global.index');
    }
}
