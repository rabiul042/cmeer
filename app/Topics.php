<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $table = 'topics';

    public function course()
    {
        return $this->belongsTo('App\Courses','course_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }


}
