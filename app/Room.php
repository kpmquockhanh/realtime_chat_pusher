<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    public function messages()
    {
        $this->hasMany(Message::class);
    }
}
