<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'password',
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'email',
        'email_verified_at',
        'phone_number',
        'city_id',
        'is_eaten',
        'last_logined_date',
        'last_logined_ip',
        'last_logined_city',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @var mixed
     */

    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id');
    }

    public function getCityName()
    {
        return !empty($city = $this->city) ? $city->name : null;
    }

}
