<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorAnswers extends Model
{

    public function doctor_courses()
    {
        return $this->belongsTo('App\DoctorsCourses','doctor_course_id', 'id');
    }

}
