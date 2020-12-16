<?php

namespace App\Listeners;

use App\Events\UserLogined;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserLoginedListener
{
    const IPINFODB_COM_API_KEY = '0dc12c558b6916f9dbfe904b5528ad2acdcea75c44d3c14d29c2ad67f1e87bb0';
    private $ipApiKey;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->ipApiKey = '0dc12c558b6916f9dbfe904b5528ad2acdcea75c44d3c14d29c2ad67f1e87bb0';
    }

    /**
     * Handle the event.
     *
     * @param  UserLogined  $event
     * @return void
     */
    public function handle()
    {
        $user = Auth::user();
        //echo $_POST['client_ip'];//js on login page finds clients IP
        $user_ip = '';
        if (!empty($_POST['client_ip'])) {
            $user_ip = $_POST['client_ip'];
        } elseif ($user_location = json_decode(file_get_contents("https://api.ipify.org/?format=json"))) {
            $user_ip = $user_location->ip;
        } else{
            $user_ip = \Request::ip();
        }

        $user_info = json_decode(file_get_contents("http://ipinfo.io/".$user_ip."/json"));
        $url = 'http://api.ipinfodb.com/v3/ip-city/?format=json&key='.self::IPINFODB_COM_API_KEY.'&ip='.$user_ip;
        $resArray = json_decode(file_get_contents($url), true);
        $user->last_logined_date = Carbon::now();
        $user->last_logined_ip = isset($user_ip) ? $user_ip : '0:0:0:0';

        if ($resArray['cityName']) {
            $user->last_logined_city = $resArray['cityName'];
        } elseif($user_info) {
            $user->last_logined_city = $user_info->city;
        } else {
            $user->last_logined_city = 'Unknown';
        }

        $user->save();
    }

}
