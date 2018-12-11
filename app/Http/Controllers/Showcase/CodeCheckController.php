<?php

namespace App\Http\Controllers\Showcase;

use App\Code;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CodeCheckController extends Controller
{
    public function getCheckCode()
    {
        return view('showcase.auth.check_code');
    }

    public function checkCode(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $codeName = preg_replace('/\t/', '', $request->code);
        if( ! ($code = Code::whereName(trim($codeName))->first()) ) {
            return redirect()->back()->withErr('Wrong code. Please enter the correct code');
        }
        if( $code->free() ) {
            session(['codeName' => $code->name, 'checkCode' => true]);
            return redirect()->route('play.game')->withMsg('The Code is free');
        }

        session(['codeID' => $code->id]);

        return redirect()->route('play.get_payment.form');
    }
}
