<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Route;
use App\Models\City;
use App\Models\User;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        $messages = Message::all();//debug - for control

        $mesListOut = DB::table('messages')
            ->leftJoin('users', 'messages.target_id', '=', 'users.id')
            ->select('users.id as user_id')
            ->addSelect('users.login')
            ->addSelect('messages.target_id')
            ->distinct()
            ->where('messages.author_id', '=', $user['id'])
            ->get();

        $mesListIn = DB::table('messages')
            ->leftJoin('users', 'messages.author_id', '=', 'users.id')
            ->select('users.id as user_id')
            ->addSelect('users.login')
            ->addSelect('messages.author_id')
            ->distinct()
            ->where('messages.target_id', '=', $user['id'])
            ->get();

        return view('messages.list',
        [
            'code' => JsonResponse::HTTP_OK,
            'messages' => $messages,
            'users' => $users,
            'logineduser' => $user,
            'mesListOut' => $mesListOut,
            'mesListIn' => $mesListIn,
        ]);
    }

    public function create(Request $request)
    {
        Message::create([
            'target_id' => $request->get('target_id'),
            'author_id' => $request->get('author_id'),
            'text' => $request->get('text'),
            'message_date' => Carbon::now()
        ]);
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        $target_id = $request->get('target_id');
        $correspondenseList = DB::table('messages')
            ->leftJoin('users', 'messages.target_id', '=', 'users.id')
            ->whereIn('messages.author_id', [$target_id, $user['id']])
            ->whereIn('messages.target_id', [$target_id, $user['id']])
            ->select('messages.author_id')
            ->addSelect('messages.target_id')
            ->addSelect('messages.text')
            ->addSelect('messages.message_date')
            ->addSelect('users.login')
            ->orderBy('messages.message_date', 'asc')
            ->get();

        return response()->json($correspondenseList);
    }

}
