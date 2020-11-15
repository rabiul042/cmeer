<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exam';

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

    public function faculty_subject()
    {
        return $this->belongsTo('App\Subjects','subject_id', 'id');
    }

    public function sessions()
    {
        return $this->belongsTo('App\Sessions','session_id', 'id');
    }

    public function question_type()
    {
        return $this->belongsTo('App\QuestionTypes','question_type_id', 'id');
    }


}
