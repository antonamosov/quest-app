<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SydneyQuest extends Model
{
    public function scopeDate($query, $day)
    {
        return $query->where('update_at', '>', $day->from)->where('update_at', '<', $day->to);
    }

    public static function reportRequestToDay($request)
    {
        $now = Carbon::now();
        $dayFrom = $now->startOfMonth()->format('Y-m-d H:i:s');
        $dayTo = $now->endOfMonth()->format('Y-m-d H:i:s');

        if( $request->day_from )
        {
            $dayFrom = $request->day_from;
            $dayTo   =  $request->day_to;
        }

        return (object) ['from' => $dayFrom, 'to' => $dayTo];
    }

    public static function reportRequestToPaySystem($request)
    {
        if ($request->pay_system === 'all')
        {
            return ['pin', 'paypal'];
        }
        else
        {
            return $request->pay_system;
        }
    }
}
