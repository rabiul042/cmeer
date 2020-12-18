<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{

    protected $table = 'results';
    public $timestamps = false;

    public function doctor_courses()
    {
        return $this->belongsTo('App\DoctorsCourses','doctor_course_id', 'id');
    }

    public function doctor_course()
    {
        return $this->belongsTo('App\DoctorsCourses','doctor_course_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subjects','subject_id','id');
    }

    public function batch()
    {
        return $this->belongsTo('App\Batches','batch_id','id');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Faculty','faculty_id','id');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam','exam_id','id');
    }

}
