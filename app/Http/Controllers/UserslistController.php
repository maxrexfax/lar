<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use \Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use DB;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Hash;



class UserslistController extends Controller
{
    private $paginQuantity;
    public function __construct()
    {
        $this->middleware('auth');
        $this->paginQuantity = 15;
    }

    public function index(Request $request)
    {
        return $this->showAllUsers($request);
    }

    public function createform()
    {
        $cities = City::all();
        return view('users.create', [
            'cities' => $cities
        ]);
    }

    public function create(UserRequest $request)
    {
        User::create([
            'login' => $request->get('login'),
            'password' => Hash::make( $request->get('password')),
            'first_name' => $request->get('first_name'),
            'middle_name' => $request->get('middle_name'),
            'last_name' => $request->get('last_name'),
            'birthday' => $request->get('birthday'),
            'email' => $request->get('email'),
            'email_verified_at' =>  Carbon::now(),
            'phone_number' => $request->get('phone_number'),
            'city_id' => intval($request->get('city_id')),
            'is_eaten' => intval($request->get('is_eaten')),
            'last_logined_date' => Carbon::now()
        ]);
        $message = 'New user saved!';
        $cities = City::all();
        return view('users.create', [
            'cities' => $cities,
        ])->with(['message' => $message]);
    }

    public function show(Request $request)
    {
        $cities = City::all();
        $id = $request->get('id');
        $user = User::findOrFail($id);
        return view('users.view', [
            'cities' => $cities,
            'user' => $user
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $cities = City::all();
        $user = User::findOrFail($id);
        //$user = User::where('id', $id)->first();
        return view('users.edit', [
            'cities' => $cities,
            'user' => $user
        ]);
    }

    public function save(UserEditRequest $request)
    {
        Validator::make($request->all(), [
            'login' => ['required', 'max:255', Rule::unique('users')->ignore($request->get('hiddenid'), 'id')],
            'email' => ['required', 'max:255', 'email', Rule::unique('users')->ignore($request->get('hiddenid'), 'id')],
        ])->validate();

        $user = User::where('id', $request->get('hiddenid'))->first();
        $user->login = $request->get('login');
        $user->first_name = $request->get('first_name');
        $user->middle_name = $request->get('middle_name');
        $user->last_name = $request->get('last_name');
        $user->birthday = $request->get('birthday');
        $user->email = $request->get('email');
        $user->phone_number = $request->get('phone_number');
        $user->city_id = $request->get('city_id');
        $user->is_eaten = $request->get('is_eaten');

        if($request->get('password'))
        {
            $user->password = Hash::make($request->get('password'));
        }
//вариант на будущее $user = User::find($id); $user->fill($request->all())->save();
        $user->save();
        return $this->showAllUsers($request);
    }


    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $user = User::find($id);
        $user->delete();
        return $this->showAllUsers($request);
    }

//if incomes $input['markid']) - selected user markes as infected
    public function changeHealthStatus(Request $request)
    {
        if ($request->get('id')) {
            $user = User::findOrFail($request->get('id'));
            $user->is_eaten = !$user->is_eaten;
        }
        $user->save();
        return \Redirect::route('/userslist');
    }

    public function filteruserslist(Request $request)
    {
        if ($request->get('paginQuant')) {
            $this->paginQuantity = $request->get('paginQuant');
        }
        $message = 'Attention! Users list filtering enabled! Click on "Reset filter" button to see all users!';
        $cities = City::all();
        $input = $request->input();
        if(!empty($request->get('citiessearch')))
        {
            $users = User::where('city_id', $request->get('citiessearch'))->orderBy('last_logined_date','desc')->simplePaginate($this->paginQuantity);
            return view('users.list', [
                'cities' => $cities,
                'users' => $users,
                'quantity' => $this->paginQuantity,
            ])->with(['message' => $message]);
        }
        elseif ($request->get('namesearch'))
        {
            $users = User::where('first_name', $request->get('namesearch'))->orderBy('last_logined_date','desc')->simplePaginate($this->paginQuantity);
        }
        elseif ($request->get('loginsearch') )
        {
            $users = User::where('login', $request->get('loginsearch'))->orderBy('last_logined_date','desc')->simplePaginate($this->paginQuantity);
        }
        elseif ($request->get('emailsearch'))
        {
            $users = User::where('email', $request->get('emailsearch'))->orderBy('last_logined_date','desc')->simplePaginate($this->paginQuantity);
        }
        else
        {
            $users= User::orderBy('last_logined_date','desc')->get();
        }
        return view('users.list', [
            'cities' => $cities,
            'users' => $users,
            'quantity' => $this->paginQuantity,
        ])->with(['message' => $message]);
    }

    public function map(Request $request)
    {
        $cities = City::all();
        $users= User::orderBy('last_logined_date','desc')->get();
        $message = "Test message";
        return view('users.map', [
            'cities' => $cities,
            'users' => $users,
            'quantity' => $this->paginQuantity,
        ])->with(['message' => $message]);
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

    private function showAllUsers(Request $request)
    {
        if ($request->get('paginQuant')) {
            $this->paginQuantity = $request->get('paginQuant');
        }
        $users = User::orderBy('last_logined_date','desc')->simplePaginate($this->paginQuantity);
        $cities = City::all();
        return view('users.list', [
            'users' => $users,
            'cities' => $cities,
            'quantity' => $this->paginQuantity,
        ]);
    }

}
