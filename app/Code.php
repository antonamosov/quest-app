<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Softon\Sms\Facades\Sms;

class Code extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name_crypt', 'name', 'user_id', 'route_id', 'payment_id', 'active', 'point_id', 'email_or_phone', 'pay_type',
        'paid_at', 'update_at', 'price'
    ];

    // pay_type:
    // not_paid, pin, paypal

    public function scopeOwn($query)
    {
        $user = Auth::user();

        if($user->hasRole('admin'))
        {
            $query = $query->whereUserId($user->id);
        }

        return $query;
    }

    public function scopePaidDate($query, $date)
    {
        return $query->where('paid_at', '>', $date[0])->where('paid_at', '<', $date[1]);
    }

    public function scopeAllPaySystems($query)
    {
        return $query->whereIn('pay_type', ['pin', 'paypal', 'generated']);
    }

    /**
     * Send code to phone or email
     *
     * @param first or second time send code (if first, link to check code, if second - to the game)
     */
    public function sendEmailOrPhone($firstOrSecond)
    {
        $routeName = $this->Route->name;
        $codeName = $this->name;

        if($firstOrSecond === 'first')
        {
            $template = '.register';
        }
        else
        {
            $template = '.after_paid';
        }

        if($firstOrSecond === 'first' and !$this->free())
        {
            $link = 'http://play.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN') . '/check_code';
        }
        else
        {
            $link = 'http://play.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN');
        }
        // EMAIL
        if ($this->type === 'email')
        {
            $template = 'email' . $template;
            $email = $this->email_or_phone;

            Mail::send($template,
                [
                    'link'      => $link,
                    'code'      => $codeName,
                    'routeName' => $routeName
                ],

                function ($message) use ($email) {
                    $message->to($email)->subject('Quest Code');
                });
        }

        //PHONE
        if ($this->type === 'phone')
        {
            $template = 'sms' . $template;
            $phone = $this->phone_code . $this->email_or_phone;

            Sms::send($phone, $template, [
                'code' => $codeName,
                'routeName' => $routeName
            ]);
            Log::info("SMS DEBUG (Code.php): Code: $codeName, Template: $template, Phone: $phone");
        }
    }


    /**
     * Get unique code
     *
     * @return bool|string
     */
    public function getUniqueCode()
    {
        $i = 0;

        // In future - will overload your server
        // Solution - Longer Code Name ($code)
        $maxIterations = 10000;

        do
        {
            //$code = str_random(6);
            $code = $this->generateSymbol() . mt_rand(0, 9999);
            $i++;
            if($i > 100)
            {
                Log::info("Warning (Code.php): when generate code $code, reached a large number of iterations (100 iterations)");
            }
        }
        while ( ! $this->checkUnique($code) && $i < $maxIterations );

        if( $i >= $maxIterations)
        {
            return false;
        }

        return $code;
    }


    private function generateSymbol($len = 1)
    {
        $b = "QWERTYUPASDFGHJKLZXCVBNM";
        $s = '';
        while($len-->0)
        {
            $s.=$b[mt_rand(0,strlen($b))];
        }
        return $s;
    }

    /**
     * Check code for unique
     *
     * @param $code
     * @return bool
     */
    public function checkUnique($code)
    {
        $validator = Validator::make(
            ['name' => $code],
            ['name' => 'unique:codes']
        );

        if($validator->fails())
        {
            return false;
        }

        return true;
    }

    /**
     * Set email_or_phone field when create code
     * Set email, if entered email
     * Set phone, if entered phone
     *
     * @param $input
     */
    public function setEmailOrPhone($input)
    {
        if(isset($input['email']))
        {
            if($input['email'])
            {
                $this->email_or_phone = $input['email'];
                $this->type = 'email';
            }
            elseif(isset($input['phone']))
            {
                $this->email_or_phone = $input['phone'];
                $this->type = 'phone';
            }
        }
    }

    /**
     * Set "active" field to true, if route is free
     * Else, set active false
     */
    public function setActiveWhenCreate()
    {
        // Check free code
        if( Route::routeIsFree($this->route_id) )
        {
            $this->active = 1;
        }
        else
        {
            $this->active = 0;
        }
    }

    /**
     * Get own codes
     *
     * @param null $filter
     * @return bool
     */
    public function ownCodes($filter = NULL)
    {
        $user = Auth::user();

        if($filter === 'date' || $filter === NULL)
        {
            if($user->hasRole('global') || $user->hasRole('api'))
            {
                return Code::orderBy('created_at', 'desc')->paginate(50);
            }

            if($user->hasRole('admin'))
            {
                return Code::whereUserId($user->id)->orderBy('created_at', 'desc')->paginate(50);
            }

            if($user->hasRole('contributor'))
            {
                return Code::whereUserId($user->partner_id)->orderBy('created_at', 'desc')->paginate(50);
            }
        }

        if($filter === 'route')
        {
            $codes = Code::own()
                ->join('routes', 'codes.route_id', '=', 'routes.id')
                ->select('codes.*')
                ->orderBy('routes.name')
                ->paginate(50);

            return $codes;
        }

        return false;
    }

    public function security()
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {
            return true;
        }

        if($user->hasRole('admin'))
        {
            if($this->user_id == $user->id)
            {
                return true;
            }
        }

        if($user->hasRole('contributor'))
        {
            if($this->user_id == $user->partner_id)
            {
                return true;
            }
        }

        return false;
    }

    public function hasRoute()
    {
        if($this->Route)
        {
            return true;
        }

        return false;
    }

    public function Route()
    {
        return $this->belongsTo('App\Route');
    }

    public function setUserId($input)
    {
        $user = Auth::user();

        if($user->hasRole('global'))
        {

        }
    }

    public function getPointByOrder($order)
    {
        if($this->Route)
        {
            return $this->Route->getPointByOrder($order);
        }

        return false;
    }

    public function Partner()
    {
        return $this->hasOne('App\Partner', 'user_id', 'user_id');
    }

    public static function ownCodesForReport($request)
    {
        $user = Auth::user();
        $day = SydneyQuest::reportRequestToDay($request);

        if( ! $request->datatable_length) {
            $paginate = 25;
        }
        else {
            $paginate = $request->datatable_length;
        }

        $pay_system = ['pin', 'paypal', 'generated'];

        $codes = Code::
        where('paid_at', '>=', $day->from)
            ->where('paid_at', '<=', $day->to)
            ->whereIn('pay_type', $pay_system);


        if($user->hasRole('global') || $user->hasRole('api'))
        {
            if($paginate)
            {
                $codes = $codes->paginate($paginate);
            }
            else
            {
                $codes = $codes->get();
            }
            return $codes;
        }

        if($user->hasRole('admin'))
        {
            $codes = $codes->whereUserId($user->id)
                ->orderBy('id', 'desc');

            if($paginate)
            {
                $codes = $codes->paginate($paginate);
            }
            else
            {
                $codes = $codes->get();
            }
            return $codes;
        }

        return false;
    }

    public function Paypal()
    {
        return $this->belongsTo('App\Transaction', 'payment_id');
    }

    public function Pin()
    {
        return $this->belongsTo('App\Pin_transaction', 'payment_id');
    }

    public function paymentId()
    {
        if($this->pay_type == 'pin')
        {
            if($this->Paypal)
            {
                return $this->Paypal->txn_id;
            }
        }
        elseif($this->pay_type === 'paypal')
        {
            if($this->Pin)
            {
                return $this->Pin->token;
            }
        }

        return '';
    }

    public function email()
    {
        if($this->type === 'email')
        {
            return $this->email_or_phone;
        }
        else{
            return '';
        }
    }

    public function phone()
    {
        if($this->type === 'phone')
        {
            return $this->email_or_phone;
        }
        else{
            return '';
        }
    }

    public function sum()
    {
        return $this->get();
    }


    /**
     * Check old code.
     * TRUE if old
     *
     * @return bool
     */
    public function old()
    {
        $twoMonthAgo = Carbon::now()->subMonth(2)->format('Y-m-d H:i:s');

        if(strtotime($twoMonthAgo) > strtotime($this->updated_at->format('Y-m-d H:i:s')))
        {
            return true;
        }

        return false;
    }

    /**
     * Check active code
     * TRUE if active and not old
     *
     * @return bool
     */
    public function active()
    {
        if( ! $this->old() && $this->active )
        {
            return true;
        }

        return false;
    }

    /**
     * Check paid code
     * TRUE if paid
     * FALSE if not paid and not free
     */
    public function paid()
    {
        if( ! $this->paid_at && ! $this->free() )
        {
            return false;
        }

        return true;
    }

    /**
     * Check code is free
     *
     * @return bool
     */
    public function free()
    {
        if( $this->Route->isFree() )
        {
            return true;
        }

        return false;
    }

    /////////////////////////////////////////////////////////////////////////////
    //////////////////////////// Delete codes ///////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    /**
     * Delete not paid codes, which created to weeks ago
     */
    public static function deleteNotPaidCodes()
    {
        $twoWeekAgo = Carbon::now()->subWeek(2)->format('Y-m-d H:i:s');
        $codes = Code::where('created_at', '<', $twoWeekAgo)->wherePaidAt(NULL)->get();
        foreach($codes as $code)
        {
            $code->forceDelete();
        }
    }

    /**
     * Delete not active codes, which not use two month
     */
    public static function deleteNotActive()
    {
        $twoMonthAgo = Carbon::now()->subMonth(2)->format('Y-m-d H:i:s');
        $codes = Code::where('updated_at', '<', $twoMonthAgo)->whereActive(false)->get();
        foreach($codes as $code)
        {
            $code->delete();
        }
    }

    /**
     * Delete active codes, which not use two month
     */
    public static function deleteActive()
    {
        $twoMonthAgo = Carbon::now()->subMonth(2)->format('Y-m-d H:i:s');
        $codes = Code::where('updated_at', '<', $twoMonthAgo)->whereActive(true)->get();
        foreach($codes as $code)
        {
            $code->delete();
        }
    }

    /**
     * Delete all codes, older, than 1 year
     */
    public function manualDelete1year()
    {
        $oneYearAgo = Carbon::now()->subYear(1)->format('Y-m-d H:i:s');
        $codes = Code::where('created_at', '<', $oneYearAgo)->get();
        $count = count($codes);
        foreach($codes as $code)
        {
            $code->forceDelete();
        }

        return $count;
    }

    /**
     * Set tour price to code, when code is paid
     *
     * @return int
     */
    public function SetPriceWhenPaid()
    {
        if($route = $this->Route)
        {
            return $route->price;
        }
        return 0;
    }

    /**
     * Get price
     *
     * @return int|mixed
     */
    public function price()
    {
        if($this->price)
        {
            return $this->price;
        }
        else
        {
            return 0;
        }
    }

}
