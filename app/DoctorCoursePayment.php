<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorCoursePayment extends Model
{
    protected $table = 'doctor_course_payment';

    public function course_info()
    {
        return $this->belongsTo('App\DoctorsCourses','doctor_course_id', 'id');
    }


}
