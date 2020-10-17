<?php

namespace App\Http\Controllers;

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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->showAllUsers();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => ['required', 'unique:users', 'max:255'],
            'password' => ['required', 'max:255'],
            'first_name' => ['required', 'max:255'],
            'middle_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'unique:users', 'max:255', 'email'],
            'phone_number' => ['max:20'],
            'city_id' => ['required'],
            'is_eaten' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect('usercreate')
                ->withErrors($validator)
                ->withInput();
        }

        $cities = City::all();
        $input = $request->input();
        $message = "";
        try {
            $user = User::create([
                'login'      => $input['login'],
                'password'  => Hash::make($input['password']),
                'first_name'     => $input['first_name'],
                'middle_name'     => $input['middle_name'],
                'last_name'     => $input['last_name'],
                'birthday'     => $input['birthday'],
                'email'     => $input['email'],
                'phone_number'     => $input['phone_number'],
                'city_id'     => intval($input['city_id']),
                'is_eaten'     => intval($input['is_eaten']),
                'last_logined_date' => Carbon::now()
            ]);
        } catch (\Exception $e) {
            $user =  null;
            $message = $e->getMessage();
            $messageStatus = 'errorStatus';
        }

        if($user) {
            $message = 'New user saved!';
            $messageStatus = "successStatus";
        }
        return view('usercreate', [
            'cities' => $cities,
        ])->with(['message' => $message, 'messageStatus' => $messageStatus]);
    }

    public function show(Request $request)
    {
        $cities = City::all();
        $input = $request->input();
        $id = $input['id'];
        $user = User::where('id', $id)->first();
        return view('userview', [
            'cities' => $cities,
            'user' => $user
        ]);
    }

    public function edit(Request $request)
    {
        $input = $request->input();
        $id = $input['id'];
        $cities = City::all();
        $user = User::where('id', $id)->first();
        return view('useredit', [
            'cities' => $cities,
            'user' => $user
        ]);
    }

    public function editsave(Request $request)
    {
        $input = $request->input();
        Validator::make($request->all(), [
            'login' => ['required', 'max:255', Rule::unique('users')->ignore($input['hiddenid'], 'id')],
            'password' => ['max:255'],
            'first_name' => ['required', 'max:255'],
            'middle_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', Rule::unique('users')->ignore($input['hiddenid'], 'id')],
            'phone_number' => ['max:20'],
            'city_id' => ['required'],
            'is_eaten' => ['required'],
        ])->validate();

        $input = $request->input();

        $user = User::where('id', $input['hiddenid'])->first();
        if(isset( $input['login']))
        {
            $user->login = $input['login'];
        }
        if(isset( $input['password']))
        {
            $user->password = Hash::make($input['password']);
        }
        if(isset( $input['first_name']))
        {
            $user->first_name = $input['first_name'];
        }
        if(isset( $input['middle_name']))
        {
            $user->middle_name = $input['middle_name'];
        }
        if(isset( $input['last_name']))
        {
            $user->last_name = $input['last_name'];
        }
        if(isset( $input['birthday']))
        {
            $user->birthday = $input['birthday'];
        }
        if(isset( $input['email']))
        {
            $user->email = $input['email'];
        }
        if(isset( $input['phone_number']))
        {
            $user->phone_number = $input['phone_number'];
        }
        if(isset( $input['city_id']))
        {
            $user->city_id = $input['city_id'];
        }
        if(isset( $input['is_eaten']))
        {
            $user->is_eaten = $input['is_eaten'];
        }
        $user->save();
        return $this->showAllUsers();
    }

    public function showAllUsers()
    {
        $cities = City::all();
        $users= User::orderBy('last_logined_date','desc')->get();
        return view('userslist', [
            'users' => $users,
            'cities' => $cities
        ]);
    }

    public function destroy(Request $request)
    {
        $input = $request->input();
        $id = $input['id'];
        $user = User::find($id);
        $user->delete();
        return $this->showAllUsers();
    }


    public function command(Request $request)
    {
        $input = $request->input();
        if(isset($input['markid']))
        {
            $user = User::findOrFail($input['markid']);
            $user->is_eaten = 1;
        }
        if(isset($input['unmarkid']))
        {
            $user = User::findOrFail($input['unmarkid']);
            $user->is_eaten = 0;
        }
        $user->save();
        return \Redirect::route('/userslist');
    }

    public function filteruserslist(Request $request)
    {
        $message = 'Attention! Users list filtering enabled! Click on "Reset filter" button to see all users!';
        $messageStatus = "infoStatus";
        $users = User::all();
        $cities = City::all();
        $input = $request->input();
        if(isset($input['citiessearch']) && $input['citiessearch']!=0)
        {
            $users = User::where('city_id', $input['citiessearch'])->orderBy('last_logined_date','desc')->get();
            return view('userslist', [
                'cities' => $cities,
                'users' => $users,
            ])->with(['message' => $message, 'messageStatus' => $messageStatus]);
        }
        elseif (isset($input['namesearch']))
        {
            $users = User::where('first_name', $input['namesearch'])->orderBy('last_logined_date','desc')->get();
        }
        elseif (isset($input['loginsearch']))
        {
            $users = User::where('login', $input['loginsearch'])->orderBy('last_logined_date','desc')->get();
        }
        elseif (isset($input['emailsearch']))
        {
            $users = User::where('email', $input['emailsearch'])->orderBy('last_logined_date','desc')->get();
        }
        else
            {
                $users= User::orderBy('last_logined_date','desc')->get();
            }
        return view('userslist', [
            'cities' => $cities,
            'users' => $users,
        ])->with(['message' => $message, 'messageStatus' => $messageStatus]);
    }

    public function createnewuser()
    {
        $cities = City::all();
        return view('usercreate', [
            'cities' => $cities
        ]);
    }
}
