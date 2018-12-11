<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Landing extends Model
{
    protected $fillable = [
         'logo_image_id', 'header', 'background', 'main_image_id', 'faq', 'image_text', 'background_image_id',
        'header_font', 'header_font_style', 'header_color'
    ];

    public function security()
    {
        if(Auth::user()->hasRole('global'))
        {
            return true;
        }

        if(Auth::user()->hasRole('admin'))
        {
            if($this->id == Auth::user()->landingId())
            {
                return true;
            }
        }

        return false;
    }

    public function LogoImage()
    {
        return $this->belongsTo('App\Image', 'logo_image_id');
    }


    public function logoImagePath()
    {
        if($image = $this->logoImage)
        {
            return $image->path;
        }
        return '';
    }

    public function logoImageName()
    {
        if($image = $this->logoImage)
        {
            return $image->name();
        }
        return '';
    }

    public function MainImage()
    {
        return $this->belongsTo('App\Image', 'main_image_id');
    }

    public function mainImagePath()
    {
        if($image = $this->mainImage)
        {
            return $image->path;
        }
        return '';
    }

    public function mainImageName()
    {
        if($image = $this->mainImage)
        {
            return $image->name();
        }
        return '';
    }

    public function BackgroundImage()
    {
        return $this->belongsTo('App\Image', 'background_image_id');
    }

    public function Faqs()
    {
        return $this->hasMany('App\Faq');
    }

    public function getFaqs()
    {

    }


    public function getFaqHeader($order)
    {
        if($faqs = $this->faqs)
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
        if($faqs = $this->faqs)
        {
            if(isset($faqs[$order]))
            {
                return $faqs[$order]->section_txt;
            }
        }

        return '';
    }


    public function hasPartner()
    {
        if($this->Partner)
        {
            return true;
        }

        return false;
    }

    public function hasDomain()
    {
        if($this->Partner)
        {
            if($this->Partner->Domain)
            {
                return true;
            }
        }

        return false;
    }

    public function Partner()
    {
        return $this->belongsTo('App\Partner', 'user_id', 'user_id');
    }

    public function getDomainSlug()
    {
        if($this->hasDomain())
        {
            return $this->Partner->Domain->slug;
        }

        return '';
    }

    public function Domain()
    {
        return $this->belongsTo('App\Domain');
    }

    public function Preview()
    {
        return $this->hasOne('App\Preview');
    }

    public function checkFields()
    {
        if( !$this )
        {
            return false;
        }

        if( !$this->logo_image_id && !$this->main_image_id && !$this->header)
        {
            return false;
        }

        return true;
    }

    public function landingUrl()
    {
        if($this->Domain)
            return 'http://' . $this->Domain->slug . '.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN');
        else return '';
    }

    public function setColumnVariable()
    {
        $column = 0;

        if($this->logoImage) {
            $column++;
        }
        if($this->mainImage) {
            $column++;
        }
        if($this->image_text) {
            $column++;
        }
        return $column;
    }
}
