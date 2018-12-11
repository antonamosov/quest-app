<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pin_transaction extends Model
{
    protected $fillable = [
        'token',
        'success',
        'description',
        'ip_address',
        'status_message',
        'error_message'
    ];
}
