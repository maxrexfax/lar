<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'login' => 'admin',
            'password' => Hash::make('1234'), // password
            'first_name' => 'name'.Str::random(4),
            'email' => Str::random(10).'@gmail.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_eaten' => 0,
            'created_at' => now()
        ];
        User::create($user);
    }
}
