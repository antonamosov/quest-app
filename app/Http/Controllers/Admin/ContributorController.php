<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContributorController extends Controller
{
    public function getList()
    {
        $user = Auth::user();

        $users = $user->getContributors();

        return view('admin.user.contributor.list')->withUsers($users);
    }

    public function edit(User $user)
    {
        if( ! $user->security() )
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $currentUser = Auth::user();
        $admins = $currentUser->getAdmins();

        return view('admin.user.contributor.edit', ['user' => $user, 'admins' => $admins]);
    }

    public function update(User $user, Request $request)
    {
        if( ! $user->security() )
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $input = $request->all();

        //dd($input);

        $validator = $this->validator_update($input);

        if($validator)
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->image_id = 0;
        $user->phone = 0;
        $user->name  = $input['name'];

        if( $input['password'] )
        {
            $user->password = bcrypt($input['password']);
        }

        $user->save();

        return redirect()->route('admin.user.contributor.list')->withMsg('Saved successful');
    }

    public function create()
    {

        $user = Auth::user();
        $admins = $user->getAdmins();

        return view('admin.user.contributor.create')->withAdmins($admins);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        //dd($input);

        if(Auth::user()->hasRole('admin'))
        {
            $input['partner_id'] = Auth::user()->id;
        }

        $validator = $this->validator($input);

        if($validator)
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User($input);

        $user->image_id = 0;
        $user->phone = 0;
        $user->role_id = Role::getContributorID();
        $user->password = bcrypt($input['password']);

        $user->save();

        return redirect()->route('admin.user.contributor.list')->withMsg('Saved successful');
    }

    private function validator($input)
    {
        $validator = Validator::make($input, [
            'name'       => 'required',
            'email' => 'unique:users|email|required',
            'password' => 'required',
            'partner_id' => 'required'
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
        if ( ! $user->security() )
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        if( ! $user->hasRole('contributor'))
        {
            return redirect()->route('admin.user.contributor.list')->withErr('User not found.');
        }

        $user->delete();

        return redirect()->route('admin.user.contributor.list')->withMsg('User deleted successful.');
    }
}
