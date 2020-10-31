<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\CityRequest;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use \Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use DB;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Hash;
use const http\Client\Curl\AUTH_ANY;


class UserslistController extends Controller
{
   public const PAGINATION_QUANTITY_VALUE = 15;
    const ROLE_ID_ADMIN = 1;
    const ROLE_ID_USER = 3;

    public function __construct()
    {
        $this->middleware('auth');
        $this->paginationQuantity = self::PAGINATION_QUANTITY_VALUE;
    }

    public function index(Request $request)
    {
        return $this->showAllUsers($request);
    }

    public function createform()
    {
        return view('users.create', [
            'cities' => City::orderBy('name','asc')->get(),
        ]);
    }

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

    public function create()
    {
        return view('users.create',
        [
            'cities' => City::orderBy('name','asc')->get(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request)
    {
        return view('users.view', [
            'cities' => City::orderBy('name','asc')->get(),
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
        $message = '';
        $tmpHashedPassword = $userIn->password;

        $userIn->fill($request->post());

        if($request->get('password') && ((Auth::user()->role_id==self::ROLE_ID_ADMIN) || Auth::user()->id==$userIn->id))
        {
            $userIn->password = Hash::make($request->get('password'));
            $message = 'Password has been changed!';
        }else{
            $userIn->password = $tmpHashedPassword;
            $message = 'Only admin can change password!';
        }

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
                $user->delete();
                $message = 'User has been deleted!';
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
        /*return view('users.city', [
            'cities' => City::orderBy('name','asc')->get(),
        ])->withSuccess('New city created!');*/
    }

    private function showAllUsers(Request $request)
    {
        if ($request->get('paginationQuantity')) {
            $this->paginationQuantity = $request->get('paginationQuantity');
        }

        $users = User::orderBy('last_logined_date','desc')->simplePaginate($this->paginationQuantity);

        return view('users.list', [
            'users' => $users,
            'cities' => City::orderBy('name','asc')->get(),
            'quantity' => $this->paginationQuantity,
        ]);
    }

}
