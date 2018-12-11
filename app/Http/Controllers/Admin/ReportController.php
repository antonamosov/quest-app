<?php

namespace App\Http\Controllers\Admin;

use App\Code;
use App\Report;
use App\Route;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function general(Request $request, Report $report)
    {
        $elements = $this->_general($request, $report);

        if(! $elements || ! $elements['elements']->count())
        {
            return redirect()->to('/admin/report/dashboard')->withErr("You still do not have clients.");
        }

        return view('admin.report.tables', $elements);
    }

    private function _general($request, $report, $allEntries = NULL)
    {
        $now = Carbon::now();
        $dayFrom = $now->startOfMonth()->format('Y-m-d H:i:s');
        $dayTo = $now->endOfMonth()->format('Y-m-d H:i:s');

        if( $request->day_from )
        {
            $dayFrom = $request->day_from;
            $dayTo   =  $request->day_to;
        }

        $this->validate($request, [
            'sort_type'         => 'in:category,route,partner',
            'pay_system'        => 'in:all,paypal,pin',
            'day_from'          => 'sometimes|date',
            'day_to'            => 'sometimes|date',
            'datatable_length'  => 'sometimes|integer'
        ]);

        $params     = (object) [
            'day'           => (object) ['from' => $dayFrom, 'to' => $dayTo],
            'calendar'      => (object) ['from' => date('M d, Y', strtotime($dayFrom)), 'to' => date('M d, Y', strtotime($dayTo))],
            'pay_system'    => $request->pay_system,
            'sort_type'     => $request->sort_type,
            'url'           => $request->url(),
            'query_string'  => $request->getQueryString()
        ];

        //dd($params);

        $elements = $report->getFullTable($request);

        if(!$elements && ! $elements->count())
        {
            return false;
        }

        return [
            'elements' => $elements,
            'params'      => $params,
            'url'       => $request->fullUrl()
        ];
    }

    public function detail(Request $request, Report $report)
    {
        $elements = $this->_detail($request, $report);

        // Output
        return view('admin.report.detailed', $elements);
    }

    private function _detail($request, $report, $allEntries = NULL)
    {
        $now = Carbon::now();
        $dayFrom = $now->startOfMonth()->format('Y-m-d H:i:s');
        $dayTo = $now->endOfMonth()->format('Y-m-d H:i:s');

        if( $request->day_from )
        {
            $dayFrom = $request->day_from;
            $dayTo   =  $request->day_to;
        }

        $this->validate($request, [
            'page'              => 'sometimes|integer',
            'filter'            => 'in:all,category,route,partner',
            'day_from'          => 'sometimes|date',
            'day_to'            => 'sometimes|date',
            'datatable_length'  => 'sometimes|integer'
        ]);

        $params     = (object) [
            'day'           => (object) ['from' => $dayFrom, 'to' => $dayTo],
            'calendar'      => (object) ['from' => date('M d, Y', strtotime($dayFrom)), 'to' => date('M d, Y', strtotime($dayTo))],
            'pay_system'    => $request->pay_system,
            'url'           => $request->url(),
            'query_string'  => $request->getQueryString()
        ];

        //dd($params);

        $codes = $report->getDetailTable($request);

        if( ! $codes)
        {
            //return redirect()->back()->withErr('Nothing founded.');
        }

        if( ! $request->all_entries )
        {
            $count = count($codes);

            // Pagination
            if( ! $request->page) {
                $page = 1;
            } else {
                $page = $request->page;
            }
            if( ! $request->datatable_length) {
                $len = 25;
            } else {
                $len = $request->datatable_length;
            }

            $codes = $codes->forPage($page, $len); //Filter the page var

            $codes->current = $page;
            $codes->countPages = (int) ceil( $count / $len );
            $codes->url = $request->fullUrl();
        }

        $sum = 0;
        foreach($codes as $code)
        {
            if($code->Route)
            {
                $sum += (int) $code->price() / 100;
            }
        }

        return [
            'codes'       => $codes,
            'params'      => $params,
            'sum'         => $sum
        ];
    }

    public function generalCSV(Request $request, Report $report)
    {
        $elements = $this->_general($request, $report, true);

        $report->generalCSV($elements);
    }

    public function detailCSV(Request $request, Report $report)
    {
        $elements = $this->_detail($request, $report, true);

        $report->detailCSV($elements);
    }

    public function dashboard(Report $report, Request $request)
    {
        $now = Carbon::now();
        $dayFrom = $now->startOfMonth()->format('Y-m-d H:i:s');
        $dayTo = $now->endOfMonth()->format('Y-m-d H:i:s');

        if( $request->day_from )
        {
            $dayFrom = $request->day_from;
            $dayTo   =  $request->day_to;
        }

        $this->validate($request, [
            'day_from'          => 'sometimes|date',
            'day_to'            => 'sometimes|date'
        ]);

        $params     = (object) [
            'day'           => (object) ['from' => $dayFrom, 'to' => $dayTo],
            'calendar'      => (object) ['from' => date('M d, Y', strtotime($dayFrom)), 'to' => date('M d, Y', strtotime($dayTo))]
        ];

        $dates =     $report->prepareDatesForDashboard($params->day);
        $users =     $report->countUsersStatisticArray($dates->dates);
        $revenues =  $report->averageRevenueStatisticArray($dates->dates);
        $statistic = $report->dashboardStatistic($dates->dates);
        $params->yInterval = json_encode($dates->yInterval);

        return view('admin.report.dashboard', [
            'users'     => json_encode($users),
            'revenues'  => json_encode($revenues),
            'params'    => $params,
            'statistic' => $statistic
        ]);
    }
}
