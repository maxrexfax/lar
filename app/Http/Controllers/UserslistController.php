<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\CityRequest;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use \Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\Message;
use App\Models\Role;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Hash;
use const http\Client\Curl\AUTH_ANY;


class UserslistController extends Controller
{
    const ROLE_ID_ADMIN = 1;
    const ROLE_ID_USER = 3;

    public $paginationQuantity = 15;

    /**
     * UserslistController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, $var1 = null, $var2 = null)
    {
        if($var1){//пример работы с опциональными переменными var1, var2
            echo $var1;
        }
        if($var2){
            echo $var2;
        }
        return $this->showAllUsers($request);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createform()
    {
        $testValueFromEnv = env("IMAP_HOSTNAME_TEST", "rr");

        return view('users.create', [
            'cities' => City::orderBy('name','asc')->get(),
            'test' => $testValueFromEnv
        ]);
        /*$view = view('users.create', [
        'cities' => City::orderBy('name','asc')->get(),
        ]);
        return view($view);*/
    }

    /**
     * @param UserRequest $request
     * @return mixed
     */
    public function store(UserRequest $request )
    {
        User::create([
            'login' => $request->post('login'),
            'password' => Hash::make( $request->post('password')),
            'first_name' => $request->post('first_name'),
            'middle_name' => $request->post('middle_name'),
            'last_name' => $request->post('last_name'),
            'birthday' => $request->post('birthday'),
            'email' => $request->post('email'),
            'email_verified_at' =>  Carbon::now(),
            'phone_number' => $request->post('phone_number'),
            'city_id' => $request->post('city_id'),
            'role_id' => self::ROLE_ID_USER,
            'is_eaten' => $request->post('is_eaten'),
            'last_logined_date' => Carbon::now()
        ]);
        return redirect()->back()->withSuccess('New user created!');

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('users.create', [
            'cities' => City::orderBy('name','asc')->get(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */


    public function show(Request $request)
    {
        //ниже код для другого проекта - находит время завершения операции с учетом выходных
        //во время выходных работа таймера не ведется
       /* $timeToExpire = 96;
        //$dt = Carbon::now();
        $date = Carbon::parse('2020-11-05 11:33:04');
        echo '<br>STARTING Date:';
        echo date_format($date,"Y/m/d H:i:s l");
        //var_dump($date);

        if($date->isWeekday()){
            echo 'Сейчас РАБОЧАЯ НЕДЕЛЯ!!';
            $weekEndDateStart = $date->copy()->next('Saturday');

            //Найти точку останова - субботу
            echo '<br>начало ближайшей субботы:';
            echo date_format($weekEndDateStart,"Y/m/d H:i:s l");
            //$date1 = Carbon::parse('2020-11-05 15:00:00');
            //echo 'date1 Date time:';
            echo '<br>';
            echo '<br>Hours Left To Saturday=';
            $hoursLeftToSaturday = $date->diffInHours($weekEndDateStart, true);
            echo $hoursLeftToSaturday;
            if($hoursLeftToSaturday>$timeToExpire){
                echo '<br>До выходных больше времени, чем указано в константе, expiration date = date+const+!!! HH MM SS<br>';
                $expirationDate = $date->copy()->addHours($timeToExpire);
                echo '<br>Date of expiration=';
                echo date_format($expirationDate,"Y/m/d H:i:s l");
            } else {
                echo '<br>До выходных меньше времени, чем указано в константе<br>';
                $expirationDate = $date->copy()->addHours($timeToExpire+48);
                echo '<br>Date of expiration=';
                echo date_format($expirationDate,"Y/m/d H:i:s l");
            }
        }
        elseif($date->isWeekend()){
            echo '<br>Сейчас выходные дни!!<br>';
            $mondayOneWeekLater = $date->startOfWeek()->addWeeks(1);
            echo '<br> Точка начала отсчета периода= ';
            echo date_format($mondayOneWeekLater,"Y/m/d H:i:s l");
            echo '<br>';
            $expirationDate = $mondayOneWeekLater->addHours($timeToExpire);
            echo '<br>Date of expiration=';
            echo date_format($expirationDate,"Y/m/d H:i:s l");
            echo '<br>';
        }*/

        $userWithRole = DB::table('roles')
            ->leftJoin('users', 'users.role_id', '=', 'roles.id')
            ->select('users.id as user_id')
            ->addSelect('users.login')
            ->addSelect('roles.roles')
            ->where('users.id', '=', $request->get('id'))
            ->get();

        return view('users.view', [
            'cities' => City::orderBy('name','asc')->get(),
            'roles' => DB::table('roles')->get(),
            'user' => User::findOrFail($request->get('id')),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request)
    {
        return view('users.edit', [
            'cities' => City::orderBy('name','asc')->get(),
            'roles' => DB::table('roles')->get(),
            'user' => User::findOrFail($request->get('id'))
        ]);
    }

    /**
     * @param UserEditRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function save(UserEditRequest $request)
    {
        $userIn = User::find($request->post('id'));
        $tmpHashedPassword = $userIn->password;
        $userIn->fill($request->post());
        $userIn->password = $tmpHashedPassword;
        $message = 'Data saved!';

        if (!empty($request->get('password'))) {
            if((Auth::user()->role_id==self::ROLE_ID_ADMIN)) {
                $userIn->password = Hash::make($request->get('password'));
                $message .= ' Password has been changed!';
            } elseif (Auth::user()->id==$userIn->id) {
                $userIn->password = Hash::make($request->get('password'));
                $message .= ' You have successfully changed your password!';
            } else {
                $message .= ' Only admin can change password!';
            }
        }
       // $userIn->middle_name = null;// пример как сохранять нулл в обычное поле, не фореин ключ
        $userIn->save();

        return $this->showAllUsers($request)->with('message', $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function destroy(Request $request)
    {
        $message = '';

        if ($request->get('id') && Auth::user()->role_id==self::ROLE_ID_ADMIN) {
            $id = $request->get('id');
            $user = User::find($id);

            if ($user) {
                DB::table('messages')->where('author_id', '=', $user->id)->delete();
                DB::table('messages')->where('target_id', '=', $user->id)->delete();
                $user->delete();
                $message = 'User and his messages has been deleted!';
            }
        } else {
            $message = 'Only admin can delete user!';
        }

        return $this->showAllUsers($request)->with('message', $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeHealthStatus(Request $request)
    {
        if ($request->get('id')) {
            $user = User::findOrFail($request->get('id'));
            $user->is_eaten = !$user->is_eaten;
        }

        $user->save();

        return redirect('userslist');
    }

    public function filteruserslist(Request $request)
    {
        if ($request->get('paginationQuantity')) {
            $this->paginationQuantity = $request->get('paginationQuantity');
        }

        $message = 'Attention! Click on "Reset filter" button to see all users! Users list filtering enabled by ';
        if (!empty($request->get('citiessearch'))) {
            $message .= 'city';
            $users = User::where('city_id', $request->get('citiessearch'))->orderBy('last_logined_date','desc')->simplePaginate($this->paginationQuantity);
            return view('users.list', [
                'cities' => City::orderBy('name','asc')->get(),
                'users' => $users,
                'quantity' => $this->paginationQuantity,
            ])->with(['message' => $message]);
        } elseif ($request->get('namesearch')) {
            $message .= 'username';
            $users = User::where('first_name', $request->get('namesearch'))->orderBy('last_logined_date','desc')->simplePaginate($this->paginationQuantity);
        } elseif ($request->get('loginsearch') ) {
            $message .= 'user login';
            $users = User::where('login', $request->get('loginsearch'))->orderBy('last_logined_date','desc')->simplePaginate($this->paginationQuantity);
        } elseif ($request->get('emailsearch')) {
            $message .= 'email';
            $users = User::where('email', $request->get('emailsearch'))->orderBy('last_logined_date','desc')->simplePaginate($this->paginationQuantity);
        } else {
            $users = User::orderBy('last_logined_date','desc')->simplePaginate($this->paginationQuantity);
            $message = "Empty choice";
        }

        return view('users.list', [
            'cities' => City::orderBy('name','asc')->get(),
            'users' => $users,
            'quantity' => $this->paginationQuantity,
        ])->with(['message' => $message]);
    }

    public function map(Request $request)
    {
        $users = User::orderBy('last_logined_date','desc')->get();
        return view('users.map', [
            'cities' => City::orderBy('name','asc')->get(),
            'users' => $users,
            'quantity' => $this->paginationQuantity,
        ]);
    }

    public function maplist()
    {
        $citieslist = DB::table('cities')
            ->select('cities.id')
            ->addSelect('cities.name')
            ->addSelect('cities.description')
            ->addSelect('cities.lat')
            ->addSelect('cities.lon')
            ->orderBy('cities.id', 'asc')
            ->get();

        return response()->json($citieslist);
    }

    public function mapadd()
    {
        return view('users.city', [
            'cities' => City::orderBy('name','asc')->get(),
        ]);
    }

    public function mapsave(CityRequest $request)
    {
        City::create([
            'name' => $request->get('name'),
            'lat' => $request->get('lat'),
            'lon' => $request->get('lon'),
            'description' => $request->get('description'),
        ]);
        return redirect()->back()->withSuccess('New city created!');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function showAllUsers(Request $request)
    {
        if (!empty($paginationQuantity = $request->get('paginationQuantity'))) {
            $this->paginationQuantity = $paginationQuantity;
        }

        $users = User::orderBy('last_logined_date','desc')->simplePaginate($this->paginationQuantity);

        return view('users.list', [
            'users' => $users,
            'cities' => City::orderBy('name','asc')->get(),
            'quantity' => $this->paginationQuantity,
        ]);
    }

    public function testReplicating()//Caution! Fields author_id and target_id must be real user id from table 'users'
    {
        $shipping = Message::create([
            'author_id' => '1',
            'target_id' => '3',
            'text' => 'TestReplicating text filling',
            'message_date' => Carbon::now(),
        ]);

        $billing = $shipping->replicate()->fill([
            'target_id' => '10'
        ]);

        $billing->save();
    }

}
