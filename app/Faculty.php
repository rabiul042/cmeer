<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $table = 'faculties';

    public function institute()
    {
        return $this->belongsTo('App\Institutes','institute_id','id');
    }

    public function course()
    {
        return $this->belongsTo('App\Courses','course_id','id');
    }

    public $timestamps = false;

    
}
