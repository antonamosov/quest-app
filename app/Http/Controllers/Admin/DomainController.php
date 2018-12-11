<?php

namespace App\Http\Controllers\Admin;

use App\Domain;
use App\Landing;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DomainController extends Controller
{
    public function getList()
    {
        $domains = Domain::get();

        $landings = Landing::get();

        return view('admin.domain.list', ['domains' => $domains, 'landings' => $landings]);
    }

    public function edit(Domain $domain)
    {
        return view('admin.domain.edit')->withDomain($domain);
    }

    public function update(Domain $domain, Request $request)
    {
        $input = $request->all();

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $domain->update($input);

        // Temp code for update relation domain with landing
        if ( ! $domain->Landing )
        {
            $landing = new Landing([
                'header' => '',
                'background' => '',
                'faq' => '',
                'image_text' => '',
                'logo_image_id' => 0,
                'main_image_id' => 0,
                'background_image_id' => 0,
                'user_id' => 0
            ]);

            $landing->domain_id = $domain->id;
            $landing->user_id = 0;

            $landing->save();
        }

        return redirect()->route('admin.domain.list')->withMsg('Saved successful');
    }

    public function create()
    {
        return view('admin.domain.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $domain = new Domain($input);

        $domain->save();

        // Automatically create landing associated with this domain
        $landing = new Landing([
            'header' => '',
            'background' => '',
            'faq' => '',
            'image_text' => '',
            'logo_image_id' => 0,
            'main_image_id' => 0,
            'background_image_id' => 0,
            'user_id' => 0
        ]);

        $landing->domain_id = $domain->id;
        $landing->user_id = 0;

        $landing->save();

        return redirect()->route('admin.domain.list')->withMsg('Saved successful');
    }

    private function validator($input)
    {
        $validator = Validator::make($input, [
            'slug'       => 'required'
        ]);

        if ($validator->fails())
        {
           return $validator;
        }
        else
        {
            return false;
        }
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();

        return redirect()->route('admin.domain.list')->withMsg('Deleted successful');
    }
}
