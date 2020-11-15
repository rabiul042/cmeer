<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms_types';

    public function user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }

}
