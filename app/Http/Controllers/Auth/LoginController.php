<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    //private $ipApiKey;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->ipApiKey = '0dc12c558b6916f9dbfe904b5528ad2acdcea75c44d3c14d29c2ad67f1e87bb0';
    }

    //Every login update date of login, IP address and cityname on this user to have ability to sort userlist by last logined date
    public function authenticated(Request $request, $user)
    {
        /*$user_ip = \Request::ip();
        $url = 'http://api.ipinfodb.com/v3/ip-city/?format=json&key='.$this->ipApiKey.'&ip='.$user_ip;
        $resArray = json_decode(file_get_contents($url), true);
        $user->last_logined_date = Carbon::now()
             ->toDateTimeString();
        $user->last_logined_ip = isset($user_ip) ? $user_ip : '0:0:0:0';
        $user->last_logined_city = isset($resArray['cityName']) ? $resArray['cityName'] : 'Unknown';
        $user->save();*/
    }
}
