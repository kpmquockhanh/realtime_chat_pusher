<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
        'maximum_user'
    ];
    public function messages()
    {
        $this->hasMany(Message::class);
    }
}
