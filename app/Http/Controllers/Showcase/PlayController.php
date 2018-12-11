<?php

namespace App\Http\Controllers\Showcase;

use App\Code;
use App\Domain;
use App\Point;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlayController extends Controller
{
    /**
     * GET code from the session
     *
     * @return null
     */
    private function code()
    {
        // Get code
        if(session('code_id'))
        {
            return Code::find(session('code_id'))->name;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * GET current point number from the session
     *
     * @return mixed|null
     */
    private function currentPoint()
    {
        if( session('current_point') ) {
            return session('current_point');
        }
        else {
            return NULL;
        }
    }

    /**
     * Index for game
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if ( $request->domain && $request->route )
        {
            session([
                'domain' => $request->domain,
                'route'  => $request->route
            ]);

            return redirect()->to('quest/register');
        }

        // Get code
        if(session('code_id'))
        {
            $code = Code::find(session('code_id'));
        }

        return view('showcase.game');
    }

    /**
     * Model: get welcome to the route
     *
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function model()
    {
        //dd(Code::find(session('code_id'))->name);
        // Get code
        if( ! $this->code() )
        {
            return redirect()->route('user.login');
        }

        $route = $this->_requestToAPI('/route?code=' . $this->code());

        if( ! $route->success )
        {
            $err = 'Error.';
            if( $route->error )
            {
                $err = 'Error: ' . $route->error;
            }
            return $err;
        }

        //dd($route);

        // Save user current information
        session([
            'current_point' => $route->response->current_point,
            'max_points'    => $route->response->count_of_points
        ]);

        // Show route
        return view('showcase.game.model.welcome')->withRoute($route->response);
    }

    /**
     * Model: GET point
     *
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function model_point()
    {
        //dd(Code::find(session('code_id'))->name);
        //dd($this->currentPoint());

        // Get code
        if( ! $this->code() )
        {
            return redirect()->route('user.login');
        }

        // Get saved current point
        if( $this->currentPoint() ) {
            $pointNumber = $this->currentPoint();
        }
        else {
            return redirect()->route('user.login');
        }

        if( session('max_points') < $pointNumber )
        {
            return redirect()->route('play.end');
        }

        // Client
        $point = $this->_requestToAPI('/route/point/' . $pointNumber . '?code=' . $this->code());

        if( ! $point->success )
        {
            $err = 'Error.';
            if( $point->error )
            {
                $err = 'Error: ' . $point->error;
            }
            return $err;
        }

        //dd($point);

        return view('showcase.game.model.point', ['point' => $point->response, 'code' => $this->code()]);
    }

    /**
     * Model: Check answer
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function model_check_answer(Request $request)
    {
        $this->validate($request, ['answer' => 'required']);

        // Get code
        if( ! $this->code() )
        {
            return redirect()->route('user.login');
        }


        // Client
        $client = new Client([
            'base_url' => [
                'http://api.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN'),
                []
            ],
            'defaults' => [
                'timeout'         => 10,
                'allow_redirects' => false
            ]
        ]);

        // Get saved current point
        if( ! ($pointNumber = $this->currentPoint()) )
        {
            return redirect()->route('user.login');
        }

        // Client
        $answer = $this->_requestToAPI('/point/' . $pointNumber . '/answer?code=' . $this->code() . '&' . 'answer=' . $request->input('answer'));

        //dd($answer);

        if( ! $answer->success )
        {
            $err = 'Error.';
            if( $answer->error )
            {
                $err = 'Error: ' . $answer->error;
            }
            return redirect()->route('play.answer')->withErr('Do not right answer. Try again.');
        }

        // Continue, if answer is right
        $pointNumber++;

        if( session('max_points') < $pointNumber )
        {
            return redirect()->route('play.end');
        }

        session(['current_point' => $pointNumber]);

        return redirect()->route('play.answer');
    }

    /**
     * Model: Core: request to API
     *
     * @param $query
     * @return mixed|object
     */
    private function _requestToAPI($query)
    {
        // Client
        $client = new Client([
            'base_url' => [
                'http://api.' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN'),
                []
            ],
            'defaults' => [
                'timeout'         => 10,
                'allow_redirects' => false
            ]
        ]);

        // Get route
        $request = $client->get($query);
        if('200' != $request->getStatusCode())
        {
            $obj = (object) [
                'response'  => false,
                'error'     => 'Error ' . $request->getStatusCode()
            ];
            return $obj;
        }
        return json_decode( $request->getBody() );
    }

    public function model_end()
    {
        return view('showcase.game.model.end');
    }

    /**
     * GET demo for partner domain
     * partner.site.com/demo
     *
     * @param $domainSlug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDemo($domainSlug)
    {
        $domain = Domain::where('slug', '=', $domainSlug)->first();

        if ( ! $domain )
        {
            return redirect()->to('http://' . getenv('DOMAIN') . '.' . getenv('MAIN_DOMAIN'));
        }

        $landing = $domain->Landing;

        if(!$landing)
        {
            return redirect()->route('showcase.demo');
        }

        return view('showcase.partner.demo')->withLanding($landing);
    }

    /**
     * GET demo for main domain
     * site.com/demo
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMainDemo()
    {
        return view('showcase.demo');
    }
}
