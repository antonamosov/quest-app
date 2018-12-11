<?php

namespace App\Http\Controllers\Showcase;

use App\Code;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    /**
     * GET payment form (after payment system select)
     *
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     *
     */
    public function payPalForm(Request $request)
    {
        if(!session('codeID'))
        {
            return 'Where are you from?';
        }

        $code = Code::find(session('codeID'));

        if(!$code)
        {
            return 'Where are you from?';
        }

        $route = $code->Route;

        $customData = [
            'code_id' => $code->id,
            'route_id' => $route->id
        ];

        $custom = json_encode($customData);

        //dd($code);

        return view('showcase.payment.form', ['route' => $route, 'custom' => $custom, 'code' => $code->id]);
    }


    /**
     * IPN Listener
     *
     * @param $request
     */
    public function ipnListener(Request $request)
    {
        $input =  $request->all();

        $input['payment_date'] = Carbon::createFromTimestamp(strtotime($input['payment_date']));

        $custom = json_decode($input['custom']);

        $transaction = new Transaction(array_merge($input, [
            'player_id' => 0,
            'player_email' => '',
            'relation_id' => 0,
            'relation_type' => '',
            'code_id' => $custom->code_id,
            'route_id' => $custom->route_id
        ]));

        // check whether the payment_status is Completed
        // check that txn_id has not been previously processed
        // check that payment_amount/payment_currency are correct
        if( ! $transaction->checkCompleted() ||
            ! $transaction->checkBusiness()  ||
            ! $transaction->checkPreviosly() ||
            ! $transaction->checkAmountAndPrice() )
        {
            return;
        }

        $transaction->save();


        // Code activate when all checks all right
        $code = Code::find($transaction->code_id);

        if( ! $code )
        {
            return;
        }

        if( $code->active )
        {
            return;
        }

        $code->active = true;
        $code->pay_type = 'paypal';
        $code->payment_id = $transaction->id;
        $code->paid_at = Carbon::now();
        $code->price = $code->setPriceWhenPaid();
        $code->save();

        $code->sendEmailOrPhone('second');

        // check that receiver_email is your PayPal email
        // process payment and mark item as paid.
        // assign posted variables to local variables

        return;
    }


}
