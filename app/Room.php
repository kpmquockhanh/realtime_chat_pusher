<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'maximum_user'
    ];
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isOwner()
    {
        return Auth::id() === $this->user_id;
    }
}
