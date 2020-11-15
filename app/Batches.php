<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batches extends Model
{
    protected $table = 'batches';

    public function institute()
    {
        return $this->belongsTo('App\Institutes','institute_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo('App\Courses','course_id', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Faculty','faculty_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subjects','subject_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch','branch_id', 'id');
    }

}
