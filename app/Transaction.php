<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'txn_id', 'mc_gross', 'mc_currency', 'payment_date', 'payment_status', 'business', 'receiver_email', 'player_id',
        'player_email', 'relation_id', 'relation_type', 'code_id', 'route_id', 'mc_currency', 'quantity',
    ];

    public function checkCompleted()
    {
        if( $this->payment_status === 'Completed' )
        {
            return true;
        }
        return false;
    }

    public function checkBusiness()
    {
        if( $this->business === 'amosaa-facilitator@mail.ru' )
        {
            return true;
        }
        return false;
    }

    public function checkPreviosly()
    {
        $transaction = Transaction::whereTxnId($this->txn_id)->wherePaymentStatus('Completed')->first();

        if( $transaction )
        {
            return false;
        }

        return true;
    }

    public function checkAmountAndPrice()
    {
        $route = $this->Route;

        if( ! $route )
        {
            return false;
        }

        if( $this->mc_gross != $route->price() &&
            //$this->mc_currency != 'AUD' &&
            $this->mc_currency != 'RUB' &&
            $this->quantity != 1)
        {
            return false;
        }

        return true;
    }

    public function Route()
    {
        return $this->belongsTo('App\Route');
    }

    public function Code()
    {
        return $this->belongsTo('App\Code');
    }
}
