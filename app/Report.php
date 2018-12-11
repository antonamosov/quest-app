<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class Report extends Model
{
    /**
     * Get data for full table
     *
     * @param $request
     * @return mixed
     */
    public function getFullTable($request)
    {
        if( ! $request->datatable_length)
        {
            $paginate = 25;
        }
        else
        {
            $paginate = $request->datatable_length;
        }
        if( $request->all_entries)
        {
            $paginate = 0;
        }

        if($request->sort_type == 'route')
        {
            $routes = Route::ownForReport($paginate);
            return $routes;
        }

        if($request->sort_type == 'category')
        {
            $categories = Category::ownForReport($paginate);
            return $categories;
        }

        if($request->sort_type == 'partner')
        {
            $partners = Partner::forReport($paginate);
            return $partners;
        }
        return false;
    }

    /**
     * Get data for detail table
     */
    public function getDetailTable($request)
    {
        $day = SydneyQuest::reportRequestToDay($request);

        $elements = $this->getFilterElement($request);

        if( ! $elements )
        {
            $codes = new Collection(new Code);
            return $codes;

        }

        $pay_system = ['pin', 'paypal', 'generated'];

        // Merge codes for all elements
        $currentUser = Auth::user();
        foreach($elements as $element)
        {
            $codes = $element->codesWithTrashed;

            if( $currentUser->hasRole('admin') )
            {
                $codes = $codes->where('user_id', '=', $currentUser->id);
            }

            $codes = $codes
                ->where('paid_at', '>=', $day->from)
                ->where('paid_at', '<=', $day->to)
                ->whereIn('pay_type', $pay_system);

            if(isset($newCodes))
            {
                $codes = $newCodes->merge($codes);
            }

            $newCodes = $codes;
        }

        if( ! isset($codes) )
        {
            $codes = new Collection(new Code);
            return $codes;

        }

        return $codes;
    }

    /**
     * Search by filter for detail table
     *
     * @param $request
     * @return bool
     */
    private function getFilterElement($request)
    {
        if($request->filter === 'route')
        {
            $routes = Route::searchRoutes($request->search);
            if(count($routes))
            {
                return $routes;
            }
        }

        elseif($request->filter == 'category')
        {
            $categories = Category::searchCategories($request->search);
            if(count($categories))
            {
                return $categories;
            }
        }

        elseif($request->filter == 'partner')
        {
            $partners = Partner::searchPartners($request->search);
            if(count($partners))
            {
                return $partners;
            }
        }

        elseif($request->filter == 'all')
        {
            return Route::own()->get();
        }
        return false;
    }

    /**
     * Generate Excel file for full table
     *
     * @param $arrays
     */
    public function generalCSV($arrays)
    {
        $elements = $arrays['elements'];
        $params = $arrays['params'];

        $fileName = 'Report-' . $params->calendar->from . '-' . $params->calendar->to;

        if(strlen($fileName)>31)
            $fileName = str_replace(' ', '', $fileName);
        if(strlen($fileName)>31)
            $fileName = str_replace(',', '', $fileName);
        if(strlen($fileName)>31)
            $fileName = str_replace('-', '', $fileName);

        $header = [
            $params->sort_type,
            $params->pay_system,
            'commission',
            'total'
        ];

        $body = [];
        foreach($elements as $el)
        {
            $body[] = [
                $el->name,
                '$ ' . $el->sum($params),
                '$ ' . $el->commission($params),
                '$ ' . $el->total($params)
            ];
        }

        $footer = [
            'Total',
            '',
            '$ ' . $el->total_sum($params),
            '$ ' . $el->total_commission($params),
            '$ ' . $el->total_total($params)
        ];

        $this->_CSV($fileName, $header, $body, $footer);
    }

    /**
     * Generate Excel file for detail table
     *
     * @param $arrays
     */
    public function detailCSV($arrays)
    {
        $codes = $arrays['codes'];
        $params = $arrays['params'];
        $sum = $arrays['sum'];

        $fileName = 'Detailed-' . $params->calendar->from . '-' . $params->calendar->to;

        if(strlen($fileName)>31)
            $fileName = str_replace(' ', '', $fileName);
        if(strlen($fileName)>31)
            $fileName = str_replace(',', '', $fileName);
        if(strlen($fileName)>31)
            $fileName = str_replace('-', '', $fileName);

        $header = [
            'Code',
            'Date',
            'Time',
            'Payment method',
            'Amount paid',
            'Payment ID',
            'Email',
            'Phone',
            'Partner',
            'Category',
            'Tour',
        ];

        //dd($codes);

        $body = [];
        foreach($codes as $code)
        {
            //dd($code->id);
            $price         = $code->price() / 100;
            $routeName     = $code->Route   ? $code->Route->name : '';
            $partnerName   = $code->Partner ? $code->Partner->name : '';
            if ($code->Route) {
                $categoryName   = $code->Route->Category ? $code->Route->Category->name : '';
            } else {
                $categoryName = '';
            };

            $body[] = [
                $code->name,
                date('Y-m-d', strtotime($code->paid_at)),
                date('H:i', strtotime($code->paid_at)),
                $code->pay_type,
                '$ ' . $price,
                $code->paymentId(),
                $code->email(),
                $code->phone(),
                $partnerName,
                $categoryName,
                $routeName,
            ];
        }

        //dd($body);

        $footer = [
            'Total',
            '',
            '',
            '',
            '',
            '$ ' . $sum
        ];

        $this->_CSV($fileName, $header, $body, $footer);
    }

    /**
     * Core function for generate Excel file
     *
     * @param $fileName
     * @param $header
     * @param $body
     * @param $footer
     */
    public function _CSV($fileName, $header, $body, $footer)
    {
        $excel = App::make('excel');

        $excel->create($fileName,function ($excel) use ($fileName, $header, $body, $footer)
        {
            $excel->sheet($fileName, function ($sheet) use ($fileName, $header, $body, $footer)
            {
                $sheet->setHeight(1, 50);
                $sheet->setHeight(3, 40);


                $sheet->cells('A1:E1', function ($cells)
                {
                    $cells->setFontSize(14);
                });

                $sheet->mergeCells('A1:E1');

                // Title
                $sheet->row(1, [ $fileName ]);

                // Font size
                $columns = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U'];
                $sheet->cells('A4:' . $columns[count($header)] . (count($body) + 4), function ($cells)
                {
                    $cells->setFontSize(10);
                });

                // Border
                $sheet->setBorder('A3:' . $columns[count($header)] . (count($body) + 4), 'thin');

                // Headers
                $sheet->row(3, array_merge(
                    ['#'],
                    $header
                ));

                $row_id = 4;
                for($i = 0; $i < count($body); $i++)
                {
                    $sheet->row($row_id++, array_merge(
                        [$i + 1],
                        $body[$i]
                    ));
                }

                $sheet->row($row_id++, $footer);
            });
        })->export('xlsx');
    }


    /**
     * Number of users per period array for dashboard
     */
    public function countUsersStatisticArray($dates)
    {
        $user = Auth::user();

        $users = [];

        for($i = 0; $i < count($dates); $i++) // Last 12 months
        {
            $codes = Code::withTrashed()
                ->allPaySystems()
                ->where('paid_at', '<', $dates[$i]['endOfMonth'])
                ->where('paid_at', '>', $dates[$i]['startOfMonth']);

            if($user->hasRole('global'))
            {
                $codes = $codes->get();
            }

            if($user->hasRole('admin'))
            {
                $codes = $codes->whereUserId($user->id)->get();
            }

            $users[] = [ strtotime($dates[$i]['startOfMonth']) * 1000, count($codes) ];
        }
        return $users;
    }

    /**
     * Average revenue per user array for dashboard
     */
    public function averageRevenueStatisticArray($dates)
    {
        $user = Auth::user();

        $revenues = [];

        for($i = 0; $i < count($dates); $i++) // Last 12 months
        {
            $codes = Code::withTrashed()
                ->allPaySystems()
                ->where('paid_at', '<', $dates[$i]['endOfMonth'])
                ->where('paid_at', '>', $dates[$i]['startOfMonth']);

            if($user->hasRole('global'))
            {
                $codes = $codes->get();
            }

            if($user->hasRole('admin'))
            {
                $codes = $codes->whereUserId($user->id)->get();
            }

            $sum = 0;
            $count = 0;
            foreach($codes as $code)
            {
                $count++;
                if($code->Route)
                {
                    $sum += $code->price() / 100;
                }
            }
            if(!$count) {
                $count++;
            }

            $revenues[] = [ strtotime($dates[$i]['startOfMonth']) * 1000, round($sum / $count) ];
        }

        return $revenues;
    }

    /**
     * Prepare dates object for graphics in dashboard
     *
     * @param $days
     * @return object
     */
    public function prepareDatesForDashboard($days)
    {
        $dates = [];

        $from = strtotime($days->from);
        $to = strtotime($days->to);

        $fromToIntervals = ($to - $from) / 20;

        for ($currentTime = $from; $currentTime < $to; $currentTime += $fromToIntervals)
        {
            $dates[] = [
                'startOfMonth' => date('Y-m-d H:i:s', $currentTime),
                'endOfMonth' => date('Y-m-d H:i:s', $currentTime + $fromToIntervals -1)
            ];
        }

        $yInterval = [ round($fromToIntervals / 24 / 60 / 60, 2), "day" ];

        return (object) ['yInterval' => $yInterval, 'dates' => $dates];
    }

    /**
     * Get statistic for header in dashboard
     *
     * @param $dates
     * @return object
     */
    public function dashboardStatistic($dates)
    {
        $user = Auth::user();

        $revenues = [];

        // Get all codes by dates
        for($i = 0, $totalCount = 0, $totalSum = 0; $i < count($dates); $i++) // Last 12 months
        {
            $codes = Code::withTrashed()
                ->allPaySystems()
                ->own()
                ->where('paid_at', '<', $dates[$i]['endOfMonth'])
                ->where('paid_at', '>', $dates[$i]['startOfMonth'])
                ->get();

            $sum = 0;
            $count = 0;
            foreach($codes as $code)
            {
                $sum = 0;
                if($code->Route)
                {
                    $count++;
                    $totalCount++;
                    $sum += $code->price() / 100;
                    $totalSum += $sum;
                }
            }
            if(!$count) {
                $count++;
            }

            $revenues[] = [ strtotime($dates[$i]['startOfMonth']) * 1000, round($sum / $count) ];
        }

        // User Statistic
        $now = Carbon::now();

        $lastWeekInterval = [
            $now->startOfWeek()->format('Y-m-d H:i:s'),
            $now->endOfWeek()->format('Y-m-d H:i:s')
        ];
        $beforeWeekInterval = [
            $now->subWeek(2)->startOfWeek()->format('Y-m-d H:i:s'),
            $now->endOfWeek()->format('Y-m-d H:i:s')
        ];

        $now = Carbon::now();

        $lastMonthInterval = [
            $now->startOfMonth()->format('Y-m-d H:i:s'),
            $now->endOfMonth()->format('Y-m-d H:i:s')
        ];
        $beforeMonthInterval = [
            $now->subMonth(2)->startOfMonth()->format('Y-m-d H:i:s'),
            $now->endOfMonth()->format('Y-m-d H:i:s')
        ];

        $lastWeekCodes = Code::own()
             ->withTrashed()
             ->paidDate($lastWeekInterval)
            ->allPaySystems()
            ->get();

        $beforeWeekCodes = Code::own()
            ->withTrashed()
            ->paidDate($beforeWeekInterval)
            ->allPaySystems()
            ->get();

        $lastMonthCodes = Code::own()
            ->withTrashed()
            ->paidDate($lastMonthInterval)
            ->allPaySystems()
            ->get();

        $beforeMonthCodes = Code::own()
            ->withTrashed()
            ->paidDate($beforeMonthInterval)
            ->allPaySystems()
            ->get();

        $countLastWeekCodes = count($lastWeekCodes) ? count($lastWeekCodes) : 0.01;
        $countLastMonthCodes = count($lastMonthCodes) ? count($lastMonthCodes) : 0.01;

        $lastWeekUsersPercent = round ( ( count($lastWeekCodes) - count($beforeWeekCodes) ) / $countLastWeekCodes * 100 , 2);
        $lastMonthUsersPercent = round ( ( count($lastMonthCodes) - count($beforeMonthCodes) ) / $countLastMonthCodes * 100 , 2);

        // Revenue statistic

        // calc revenue
        $lastWeekRevenue = $this->calcRevenue($lastWeekCodes);
        $lastMonthRevenue = $this->calcRevenue($lastMonthCodes);
        $beforeMonthRevenue = $this->calcRevenue($beforeMonthCodes);
        $beforeWeekRevenue = $this->calcRevenue($beforeWeekCodes);

        // calc revenue in percents
        $lastWeekRevenue = $lastWeekRevenue ? $lastWeekRevenue : 0.01;
        $lastMonthRevenue = $lastMonthRevenue ? $lastMonthRevenue : 0.01;

        $lastWeekRevenuePercent = round ( ( $lastWeekRevenue - $beforeWeekRevenue ) / $lastWeekRevenue * 100 , 2);
        $lastMonthRevenuePercent = round ( ( $lastMonthRevenue - $beforeMonthRevenue ) / $lastMonthRevenue * 100 , 2);

        // Prepare statistic object
        $statistic = (object) [
            'totalUsers' => $totalCount,
            'lastWeekUsers' => $lastWeekUsersPercent,
            'lastMonthUsers' => $lastMonthUsersPercent,
            'lastWeekUsersColor' => $this->getLastWeekColorPrecentage($lastWeekUsersPercent),
            'lastMonthUsersColor' => $this->getLastWeekColorPrecentage($lastMonthUsersPercent),

            'totalRevenue' => $totalSum,
            'lastWeekRevenue' => $lastWeekRevenuePercent,
            'lastMonthRevenue' => $lastMonthRevenuePercent,
            'lastWeekRevenueColor' => $this->getLastWeekColorPrecentage($lastWeekRevenuePercent),
            'lastMonthRevenueColor' => $this->getLastWeekColorPrecentage($lastMonthRevenuePercent),
        ];

        return $statistic;
    }

    /**
     * Calc revenue for codes
     *
     * @param $codes
     * @return float|int
     */
    public function calcRevenue($codes)
    {
        $sum = 0;
        foreach($codes as $code)
        {
            if($code->Route)
            {
                $sum += $code->price() / 100;
            }
        }

        return $sum;
    }

    /**
     * Get percentage colors for dashboard header
     *
     * @param $value
     * @return string
     */
    public function getLastWeekColorPrecentage($value)
    {
        if($value >= 0)
        {
            return 'green';
        }
        else
        {
            return 'red';
        }
    }

}
