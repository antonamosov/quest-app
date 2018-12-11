<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [
        'slug', 'domain_id'
    ];

    public function categories()
    {
        //$partner = Partner::where('')
    }

    public function Partner()
    {
        return $this->hasOne('App\Partner', 'domain_id');
    }

    public function getDomainBySlug($slug)
    {
        return Domain::whereSlug($slug)->first();
    }

    public function Landing()
    {
        return $this->hasOne('App\Landing');
    }
}
