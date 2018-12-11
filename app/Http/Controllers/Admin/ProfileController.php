<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $this->validate($request, [
            'password'          => 'sometimes',
            'confirm_password'  => 'sometimes',
            'email'             => Rule::unique('users')->ignore($user->email, 'email')
        ]);

        if($request->password != $request->confirm_password)
        {
            return redirect()->back()->withErr('Passwords do not match.');
        }

        if($request->password && $request->confirm_password)
        {
            $user->password = bcrypt($request->password);
        }
        $user->email = $request->email;
        $user->update();

        return redirect()->back()->withMsg('Profile updated.');
    }
}
