<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institutes extends Model
{
    protected $table = 'institutes';

    public function user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }

    public $timestamps = false;
}
