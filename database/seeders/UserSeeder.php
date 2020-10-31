<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    private const ROLE_ID_USER = 3;
    public function run()
    {
        $user = [
            'login'                 => 'SeederUser_'.Str::random(4),
            'password'              => Hash::make('1234'),
            'first_name'            => 'SeederUserName'.Str::random(4),
            'email'                 => Str::random(5).'@gmail.com',
            'email_verified_at'     => Carbon::now(),
            'remember_token'        => Str::random(10),
            'city_id'              => 1,
            'role_id'              => ROLE_ID_USER,
            'is_eaten'              => 0,
            'created_at'            => now()
        ];
        User::create($user);
    }
}
