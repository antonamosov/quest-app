<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'code_id', 'status'
    ];

    public function checkPayment($code)
    {
        if($code->paid_at)
        {
            return true;
        }

        return false;
    }

}
