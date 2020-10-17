<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
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
        $cities = City::all();
        $users = User::all();
        $messages = Message::all();

        $messagesOutgoing = DB::table('messages')
            ->leftJoin('users', 'messages.target_id', '=', 'users.id')
            ->where('messages.author_id', '=', $user['id'])
            ->get();

        $messagesIncoming = DB::table('messages')
            ->leftJoin('users', 'messages.author_id', '=', 'users.id')
            ->where('messages.target_id', '=', $user['id'])
            ->get();

        return view('messagelist', [
            'messages' => $messages,
            'messagesOutgoing' => $messagesOutgoing,
            'messagesIncoming' => $messagesIncoming,
            'cities' => $cities,
            'users' => $users,
            'logineduser' => $user,
        ]);
    }

    public function create(Request $request)
    {
        $input = $request->input();
        $author_id = $input['author_id'];
        $target_id = $input['target_id'];
        $cities = City::all();
        $users = User::all();
        $messages = Message::all();
        return view('messagelist', [
            'messages' => $messages,
            'cities' => $cities,
            'users' => $users,
            'author_id' => $author_id,
            'target_id' => $target_id,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
