<?php

namespace App\Http\Controllers\Showcase;

use App\Code;
use App\Pin_transaction;
use App\Route;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Omnipay\Common\GatewayFactory;
use Omnipay\Omnipay;

class PinPaymentController extends Controller
{
    /**
     * GET PIN Payment form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function payPinPaymentForm(Request $request)
    {
        if(!session('codeID')) {
            return 'Where are you from?';
        }

        $code = Code::find(session('codeID'));
        if(!$code) {
            return 'Where are you from?';
        }

        $route = $code->Route;

        if($code->type === 'email') {
            $email = $code->email_or_phone;
        }
        else {
            $email = '';
        }

        return view('showcase.payment.pin_payment_form', [
            'route' => $route,
            'email' => $email,
            'code'  => $code
        ]);
    }

    /**
     * PIN Payment action after submitting form
     *
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function postPinPayment(Request $request)
    {
        if(!$request->code)
        {
            return 'Where are you from?';
        }

        $code = Code::whereNameCrypt($request->code)->first();

        if(!$code)
        {
            return 'Where are you from?';
        }

        $route = $code->Route;

        $code->active = true;
        $code->pay_type = 'pin';
        $code->payment_id = 0;//$transaction->id;
        $code->paid_at = Carbon::now();
        $code->price = $code->setPriceWhenPaid();
        $code->save();

        $code->sendEmailOrPhone('second');

        return redirect()->route('show.success', ['code' => $code->id]);
    }


}
