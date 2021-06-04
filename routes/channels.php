<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('logined-now.{id}', function ($user, $id) {
    //return $user->id === User::find($id)->id;
    return [
        'id' => $user->id,
        'login' => $user->login
    ];
});

Broadcast::routes(['middleware' => ['web', 'auth']]);
Broadcast::channel('chat.{task_id}', \App\Broadcasting\MessagesChannel::class);

//Метод ниже заменяет файл app/Broadcasting/MessagesChannel.php и строку выше
//Broadcast::channel('chat.{task_id}', function(\App\User $user, int $task_id) {
//    return true || false;
//});
