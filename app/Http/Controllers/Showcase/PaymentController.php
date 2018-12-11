<?php

namespace App\Http\Controllers\Showcase;

use App\Code;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Payment;
use App\Route;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     *
     * GET select form between two payment systems (after successful verification)
     *
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     *
     */
    public function index(Request $request)
    {
        if($codeName = $request->code)
        {
            $code = Code::whereName($codeName)->first();
            $route = $code->Route;
        }
        elseif($codeID = session('codeID'))
        {
            $code = Code::find($codeID);
            if(!$code) {
                return 'Where are you from?';
            }
            $route = $code->Route;
        }
        else {
            return 'Where are you from?';
        }

        return view('showcase.payment.select_system', [
            'email' => $request->email ? $request->email : '',
            'route' => $route,
            'code' => $code
        ]);
    }

    /**
     * POST after select pay system
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSelected(Request $request)
    {
        $input = $request->all();

        if(!session('codeID'))
        {
            return 'Where are you from?';
        }

        if ($input['tag'][0] == 'paypal')
        {
            return redirect()->route('paypal.form');
        }

        if ($input['tag'][0] == 'pin_payment')
        {
            return redirect()->route('pin_payment.form');
        }

        return redirect()->back()->withErr('Select Payment System');
    }


    /**
     * GET success payment (after payment) (from PayPal site).
     * Check success payment.
     *
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSuccess(Request $request)
    {
        /*//dd($request->all());
        // If PIN Payment
        if($request->token)
        {
            $code = Code::whereNameCrypt($request->token)->first();
            if($code)
            {
                $code->active = true;
                $code->pay_type = 'pin';
                $code->payment_id = 0; //$transaction->id;
                $code->paid_at = Carbon::now();
                $code->price = $code->setPriceWhenPaid();
                $code->save();

                $code->sendEmailOrPhone('second');
            }
        }
        else*/
        {
            $codeID = $request->code;
            $code = Code::find($codeID);
        }

        // It go to post success
        /*if( ! $payment->checkPayment($codeID) )
        {
            return view('showcase.payment.waiting');
        }*/

        if(!$code)
        {
            return 'Where are you from?';
        }

        return view('showcase.payment.success', [
            'code' => $code,
            'route' => $code->Route
        ]);
    }

    /**
     * Check code paid (from success page)
     * POST http://play.site.com/quest/payment_success?code=50
     *
     * @param Payment $payment
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|string
     */
    public function success(Payment $payment, Request $request)
    {
        $codeID = $request->code;
        $code = Code::find($codeID);
        if(!$code)
        {
            return 'Where are you from?';
        }

        if( ! $payment->checkPayment($code) )
        {
            // Redirect back
            return view('showcase.payment.success', [
                'code' => $code,
                'route' => $code->Route
            ]);
        }

        // If paid, redirect to the game
        session(['codeName' => $code->name, 'checkCode' => true]);
        return redirect()->route('play.game');
    }


}
