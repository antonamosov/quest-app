<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preview extends Landing
{
    public $table = 'preview_landings';

    protected $fillable = [
        'logo_image_id', 'header', 'background', 'main_image_id', 'faq', 'landing_id', 'image_text', 'background_image_id'
    ];

    public function Landing()
    {
        return $this->belongsTo('App\Landing');
    }

    public function Faqs()
    {
        return $this->hasMany('App\PreviewFaq');
    }

    public function previewFaqs()
    {
        return $this->hasMany('App\PreviewFaq', 'landing_id');
    }

    public function getFaqHeader($order)
    {
        if($faqs = $this->previewFaqs)
        {
            if(isset($faqs[$order]))
            {
                return $faqs[$order]->section_header;
            }
        }

        return '';
    }

    public function getFaqTxt($order)
    {
        if($faqs = $this->previewFaqs)
        {
            if(isset($faqs[$order]))
            {
                return $faqs[$order]->section_txt;
            }
        }

        return '';
    }
}
