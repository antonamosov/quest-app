<?php

namespace App\Http\Controllers\Admin;

use App\Pin_transaction;
use App\Report;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PinController extends Controller
{
    public function getList(Request $request)
    {
        $transactions = Pin_transaction::orderBy('id', 'desc')->paginate(50);

        $params     = (object) [
            'url'           => $request->url(),
            'query_string'  => $request->getQueryString()
        ];

        return view('admin.pin.list', [
            'transactions'  => $transactions,
            'params'        => $params
        ]);
    }
    public function generateExcel(Report $report)
    {
        $transactions = Pin_transaction::orderBy('id', 'desc')->paginate(50);

        $fileName = 'PIN Transactions';
        $header = [
            'Token',
            'Description',
            'IP address',
            'Status message',
            'Date'
        ];

        $body = [];

        foreach($transactions as $transaction)
        {
            $body[] = [
                $transaction->token,
                $transaction->description,
                $transaction->ip_address,
                $transaction->status_message,
                $transaction->created_at
            ];
        }

        $report->_CSV($fileName, $header, $body, []);
    }

}
