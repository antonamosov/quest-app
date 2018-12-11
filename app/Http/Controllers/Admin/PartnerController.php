<?php

namespace App\Http\Controllers\Admin;

use App\Domain;
use App\Partner;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class PartnerController extends Controller
{
    public function getList()
    {
        $partners = Partner::get();

        return view('admin.partner.list')->withPartners($partners);
    }

    public function edit(Partner $partner)
    {
        //dd($partner);
        $users = Auth::user()->getAdmins();
        $domains = Domain::get();

        return view('admin.partner.edit', ['users' => $users, 'partner' => $partner, 'domains' => $domains]);
    }

    public function update($partner_id, Request $request)
    {
        $partner = Partner::find($partner_id);

        $this->validate($request, [
            'name'       => 'required',
            'domain_id' => Rule::unique('partners')->ignore($partner->domain_id, 'domain_id'),
            'user_id'   => Rule::unique('partners')->ignore($partner->user_id, 'user_id'),
            'percent' => 'integer|max:100|min:0'
        ]);

        $partner->update($request->all());

        return redirect()->route('admin.partner.list')->withMsg('Saved successful');
    }

    public function create()
    {
        $user = Auth::user();
        $users = $user->getAdmins();
        $domains = Domain::get();

        //dd($domains);

        return view('admin.partner.create', ['users' => $users, 'domains' => $domains]);
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $validator = $this->validator($request->all());

        if($validator)
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->all();

        if( ! $request->max_free )
        {
               $input['max_free'] = 0;
        }

        $partner = new Partner($input);

        $partner->save();

        return redirect()->route('admin.partner.list')->withMsg('Saved successful');
    }

    private function validator($input)
    {
        if(! $input['user_id'])
        {
            $input['user_id'] = NULL;
        }

        if(! $input['domain_id'])
        {
            $input['domain_id'] = NULL;
        }

        $validator = Validator::make($input, [
            'name'       => 'required',
            'user_id' => 'unique:partners',
            'domain_id' => 'unique:partners',
            'percent' => 'integer|max:100|min:0'
        ]);

        if ($validator->fails())
        {
            return $validator;
        }

        return false;
    }

    private function validator_update($input, $partner)
    {
        $validator = Validator::make($input, [
            'name'       => 'required',
            'user_id' => 'unique:partners,'.$partner->user_id,
            'domain_id' => 'unique:partners,'.$partner->domain_id,
            'percent' => 'integer|max:100|min:0'
        ]);

        if ($validator->fails())
        {
            return $validator;
        }

        return false;
    }


    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partner.list')->withMsg('Deleted successful');
    }
}
