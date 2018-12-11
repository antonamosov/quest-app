<?php

namespace App\Http\Controllers\Admin;

use App\Domain;
use App\Faq;
use App\Image;
use App\Landing;
use App\Partner;
use App\Preview;
use App\PreviewFaq;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LandingController extends Controller
{
    public function getList()
    {
        $landings = Landing::get();

        return view('admin.landing.list')->withLandings($landings);
    }

    public function edit(Landing $landing)
    {
        //dd($landing->LogoImage);
        return view('admin.landing.edit')->withLanding($landing);
    }

    public function preview(Landing $landing, Request $request)
    {
        if ( ! Auth::user()->Partner )
        {
            return redirect()->back()->withErr('You are not associated with any partner');
        }

        if ( ! Auth::user()->Partner->Domain )
        {
            return redirect()->back()->withErr('Your partner is not associated with any sub domain');
        }

        if ( ! Auth::user()->Partner->Domain->Landing )
        {
            return redirect()->back()->withErr('Your domain is not associated with any landing');
        }

        $landing = Auth::user()->Partner->Domain->Landing;

        $faqs = $landing->faqs;

        if($request->input('preview') == 1 )
        {
            $preview = $landing->Preview;
            $preview->id = $landing->id;
            $preview->domain_id = $landing->domain_id;
            $landing = $preview;
            $faqs = $preview->previewFaqs;
        }

        return view('admin.landing.preview', [
            'landing' => $landing,
            'faqs'    => $faqs
        ]);
    }

    public function update(Landing $landing, Request $request, Image $image)
    {
        $input = $request->all();

        //dd($input);

        $input = $image->formActionLanding($input);

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $landing->update($input);


        $faqHeaderArr = $input['faq_header'];
        $faqTxtArr = $input['faq_txt'];

        // Delete Faqs
        //
        $faqs = $landing->faqs;

        foreach ($faqs as $faq)
        {
            $faq->delete();
        }
        // Save Faqs
        //
        for ($i = 0; $i < count($faqHeaderArr); $i++)
        {
            if ($faqHeaderArr[$i])
            {
                $faq = new Faq([
                    'section_header'    => $faqHeaderArr[$i],
                    'section_txt'       => $faqTxtArr[$i],
                    'user_id'       => $landing->user_id,
                    'landing_id'      => $landing->id
                ]);

                $faq->save();
            }
        }


        return redirect()->to('/admin/landing/preview')->withMsg('Saved successful.');
    }

    public function previewUpdate($landingID, Request $request, Image $image)
    {
        $input = $request->all();

        //dd($input);

        $input = $image->formActionLanding($input);

        if($validator = $this->validator($input))
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $landing = Preview::whereLandingId($landingID)->first();

        if ( ! $landing )
        {
            $landing = new Preview(array_merge([
                'landing_id' => (int) $landingID,
            ], $input));

            $landing->save();
        }
        else
        {
            $landing->update($input);
        }

        $faqHeaderArr = $input['faq_header'];
        $faqTxtArr = $input['faq_txt'];

        // Delete Faqs
        //
        $faqs = $landing->faqs;

        foreach ($faqs as $faq)
        {
            $faq->delete();
        }
        // Save Faqs
        //
        for ($i = 0; $i < count($faqHeaderArr); $i++)
        {
            if ($faqHeaderArr[$i])
            {
                $faq = new PreviewFaq([
                    'section_header'    => $faqHeaderArr[$i],
                    'section_txt'       => $faqTxtArr[$i],
                    'user_id'           => $landing->user_id,
                    'preview_id'        => $landing->id,
                    'landing_id'        => $landing->Landing->id,
                ]);

                $faq->save();
            }
        }

        return redirect()->to('/admin/landing/preview?preview=1');
    }

    private function validator($input)
    {
        $validator = Validator::make($input, [
            'header' => 'required'
        ]);

        if ($validator->fails())
        {
            return $validator;
        }

        return false;
    }

    public function notFound()
    {

    }

    public function destroy(Landing $landing)
    {
        $landing->delete();

        return redirect()->back()->withMsg('Deleted successful.');
    }

    public function showPreview($landingID)
    {
        $sub = explode('?', $landingID);

        $preview = Preview::whereLandingId($sub[0])->first();

        if ( ! $preview )
        {
            return;
        }

        $domain = $preview->Landing->Domain;

        if ( ! $domain )
        {
            return 'Domain not found. Do you have domain?';
        }

        if($partner = Auth::user()->Partner)
        {
            $categories = $partner->landingCategories();
        }
        else
        {
            $categories = false;
        }

        //dd($categories);

        return view('showcase.partner.landing', [
            'categories' => $categories,
            'domain' => $domain,
            'landing' => $preview
        ]);
    }

    public function destroyImage($landingID, Request $request)
    {
        $this->validate($request, [
            'image_type' => 'required|in:logo,main'
        ]);

        $landing = Landing::find($landingID);

        if( ! $landing->security() )
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $imageType = $request->image_type;

        if($imageType === 'logo')
        {
            $landing->logo_image_id = 0;
        }
        if($imageType === 'main')
        {
            $landing->main_image_id = 0;
        }

        $landing->save();

        return redirect()->back()->withMsg("The $imageType image was successfully deleted.");
    }
}
