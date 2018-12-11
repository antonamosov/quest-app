<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PartnerAdminController extends Controller
{
    public function getList()
    {
        $user = Auth::user();

        $users = $user->getAdmins();

        return view('admin.user.admin.list')->withUsers($users);
    }

    public function edit(User $user)
    {
        return view('admin.user.admin.edit')->withUser($user);
    }

    public function update(User $user, Request $request)
    {
        $input = $request->all();

        //dd($input);

        $validator = $this->validator_update($input);

        //dd($validator);

        if($validator)
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->image_id = 0;
        $user->phone = 0;
        $user->partner_id = 0;
        $user->name  = $input['name'];

        if( $input['password'] )
        {
            $user->password = bcrypt($input['password']);
        }

        $user->save();

        return redirect()->route('admin.user.admin.list')->withMsg('Saved successful');
    }

    public function create()
    {
        return view('admin.user.admin.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = $this->validator($input);

        //dd($validator);

        if($validator)
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User($input);

        $user->image_id = 0;
        $user->phone = 0;
        $user->partner_id = 0;
        $user->role_id = Role::getAdminID();
        $user->password = bcrypt($input['password']);

        $user->save();

        return redirect()->route('admin.user.admin.list')->withMsg('Saved successful');
    }

    private function validator($input)
    {
        $validator = Validator::make($input, [
            'name'       => 'required',
            'email' => 'unique:users|email|required',
            'password' => 'required'
        ]);

        if ( $input['password'] != $input['password_confirm'] )
        {
            $validator->getMessageBag()->add('password', 'Passwords do not match.');

            return $validator;
        }

        if ($validator->fails())
        {
            return $validator;
        }
        else
        {
            return false;
        }
    }

    private function validator_update($input)
    {
        $validator = Validator::make($input, [
            'name'       => 'required'
        ]);

        if ( $input['password'] != $input['password_confirm'] )
        {
            $validator->getMessageBag()->add('password', 'Passwords do not match.');

            return $validator;
        }

        if ($validator->fails())
        {
            return $validator;
        }
        else
        {
            return false;
        }
    }

    public function destroy(User $user)
    {
        if( ! $user->hasRole('admin'))
        {
            return redirect()->route('admin.user.admin.list')->withErr('User not found.');
        }

        $user->delete();

        return redirect()->route('admin.user.admin.list')->withMsg('User deleted successful.');
    }
}
