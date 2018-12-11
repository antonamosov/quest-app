<?php

namespace App\Http\Controllers\Admin;

use App\Code;
use App\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Route;

class CodeController extends Controller
{
    public function getList(Request $request, Code $code, Route $route)
    {
        $codes = $code->ownCodes($request->sort);
        $routes = $route->ownRoutes();

        $params     = (object) [
            'url'           => $request->url(),
            'query_string'  => $request->getQueryString(),
            'linkAppends'  =>  $request->sort ? ['sort' => $request->sort] : NULL
        ];

        return view('admin.code.list', [
            'codes' => $codes,
            'routes' => $routes,
            'params' => $params
        ]);
    }

    public function generateExcel(Code $code, Report $report)
    {
        $codes = $code->ownCodes();

        if(!$codes)
        {
            return redirect()->back()->withErr('Codes not found.');
        }

        $fileName = 'Codes list';
        $header = [
            'Code',
            'Tour',
            'Email or Phone',
            'Active'
        ];
        $body = [];
        $i = 0;
        foreach ($codes as $code)
        {
            $body[$i] = [
                $code->name,
                $code->Route ? $code->Route->name : '',
                $code->email_or_phone,
                $code->active ? 'Yes' : 'No'
            ];
            $i++;
        }

        $report->_CSV($fileName, $header, $body, []);
    }

    public function store(Code $codes, Request $request)
    {
        if($validator = $this->validator($request->all()))
        {
            $request->session()->flash('modalErr', 'myModal_code_generate');

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $code = new Code;

        if ( ! ($code->name = $codes->getUniqueCode()) )
        {
            return redirect()->back()->withErr('All codes busy.');
        }

        $code->name_crypt     = bcrypt($code->name);
        $code->active         = 1;
        $code->route_id       = $request->input('route_id');
        $code->point_id       = 0;
        $code->payment_id     = 0;
        $code->type           = 'email';
        $code->email_or_phone = '';
        $code->paid_at        = Carbon::now();
        $code->pay_type       = 'generated';

        if( ! $code->Route->security() )
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $code->user_id = $code->Route->user_id;

        $code->save();

        return redirect()->back()->withMsg('Code generated successful.');
    }

    public function activate(Code $code)
    {
        if ( ! $code->security() )
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        //dd($code);

        $code->active = 1;
        $code->point_id = 1;

        $code->update();

        return redirect()->back()->withMsg('Code activated successful.');
    }

    public function deActivate(Code $code)
    {
        if ( ! $code->security() )
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $code->active = 0;

        $code->save();

        return redirect()->back()->withMsg('Code deactivated successful.');
    }

    public function destroy(Code $code)
    {
        if( ! $code->security())
        {
            return redirect()->back()->withErr('Permission denied.');
        }

        $code->delete();

        return redirect()->back()->withMsg('Code deleted successful.');
    }

    private function validator($input)
    {
        $validator = Validator::make( $input, [
            'route_id'          => 'required',
        ]);

        if($validator->fails())
        {
            return $validator;
        }
        else
        {
            return false;
        }
    }

    public function destroy1year(Code $code)
    {
        $count = $code->manualDelete1year();

        if($count)
        {
            return redirect()->back()->withMsg($count . ' codes, older than 1 year, deleted successful.');
        }
        else
        {
            return redirect()->back()->withErr('No codes for delete');
        }

    }
}
