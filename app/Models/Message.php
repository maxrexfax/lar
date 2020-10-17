<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'author_id',
        'target_id',
        'text',
        'message_date',
    ];

    public function author()
    {
        return $this->hasOne('App\Models\User', 'id', 'author_id');
    }
    public function getAuthorLogin()
    {
        if($this->author->login!=null)
        {
            return $this->author->login;
        }
        return 0;
    }
    public function recipient()
    {
        return $this->hasOne('App\Models\User', 'id', 'target_id');
    }
    public function getRecipientLogin()
    {
        if($this->recipient->login!=null)
        {
            return $this->recipient->login;
        }
        return 0;
    }
}
