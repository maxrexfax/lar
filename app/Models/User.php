<?php

namespace App\Models;

use App\Events\onUserBootEvent;
use App\Traits\ModelBootTranslator;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use ModelBootTranslator;

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
        'role_id',
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

    public static function boot()
    {
        //Log::info('Before boot', [1,2,3]);
        $class = static::class;
        Log::info('Before boot,  class='.$class);
        parent::boot();
        event(new onUserBootEvent());
        User::retrieved(function ($model){
           // Log::info( $model->getAttributes());   //or $this->getAttributes()
           // $model->login = 'test_ch_login';
        });
    }



    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id');
    }


    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public function messageOut()
    {
        return $this->hasMany(Message::class, 'author_id', 'id');
    }

    public function messageIn()
    {
        return $this->hasMany(Message::class, 'target_id', 'id');
    }

    public function getMessagesOutQuantity($target_id)
    {
        return $this->messageOut->where('target_id', $target_id)->count();
    }

    public function getMessagesInQuantity($author_id)
    {
        return $this->messageIn->where('author_id', $author_id)->count();
    }


}
