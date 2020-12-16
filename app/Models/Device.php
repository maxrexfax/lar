<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'device_name',
        'device_connect_token',
        ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
