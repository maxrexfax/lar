<?php

namespace App\Listeners;

use App\Events\UserLogined;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class UserLoginedListener
{
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
     * @param  object  $event
     * @return void
     */
    public function handle()
    {
        $user = Auth::user();
        $user_ip = json_decode(file_get_contents("https://api.ipify.org/?format=json"));
        $userInfo = json_decode(file_get_contents("http://ipinfo.io/".$user_ip->ip."/json"));
        $user->last_logined_date = Carbon::now()/*->toDateTimeString()*/;
        $user->last_logined_ip = $user_ip->ip;
        $user->last_logined_city = $userInfo->city;
        $user->save();
    }
}
