<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorExam extends Model
{
    protected $table = 'doctor_exams';

    public function doctor_course()
    {
        return $this->belongsTo('App\DoctorsCourses','doctor_course_id', 'id');
    }

    public function doctor_package()
    {
        return $this->belongsTo('App\DoctorPackage','doctor_package_id', 'id');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam','exam_id', 'id');
    }

}
