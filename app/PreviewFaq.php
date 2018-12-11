<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreviewFaq extends Model
{
    protected $fillable = [
        'section_header',
        'section_txt',
        'user_id',
        'landing_id',
        'preview_id'
    ];
}
