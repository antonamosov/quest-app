<?php

namespace App\Http\Controllers\Admin;

use App\Report;
use App\Transaction;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaypalController extends Controller
{
    public function getList(Request $request)
    {
        $transactions = Transaction::orderBy('id', 'desc')->paginate(50);

        $params     = (object) [
            'url'           => $request->url(),
            'query_string'  => $request->getQueryString()
        ];

        return view('admin.paypal.list', [
            'transactions'  => $transactions,
            'params'        => $params
        ]);
    }

    public function generateExcel(Report $report)
    {
        $transactions = Transaction::orderBy('id', 'desc')->paginate(50);

        $fileName = 'PayPal Transactions';
        $header = [
            'TXN ID',
            'SUM',
            'Payment Status',
            'Receiver Email',
            'Date',
            'Tour Name',
            'Code'
        ];

        $body = [];

        foreach($transactions as $transaction)
        {
            $body[] = [
                $transaction->txn_id,
                $transaction->mc_gross,
                $transaction->payment_status,
                $transaction->receiver_email,
                $transaction->payment_date,
                $transaction->Route ? $transaction->Route->name : '',
                $transaction->Code ? $transaction->Code->name : ''
            ];
        }

        $report->_CSV($fileName, $header, $body, []);
    }
}
