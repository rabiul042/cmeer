<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineExam extends Model
{
    //protected $table = 'online_exams';
    protected $table = 'online_exam';
    
    public function disciplines()
    {
        return $this->hasMany('App\OnlineExamDiscipline','online_exam_id','id');
    }
    
    public function batches()
    {
        return $this->hasMany('App\OnlineExamTopics','topic_id','topic_id');
    }

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

    public function topic()
    {
        return $this->belongsTo('App\Topics','topic_id', 'id');
    }

    public function batch()
    {
        return $this->belongsTo('App\Batches','batch_id', 'id');
    }

    public function session()
    {
        return $this->belongsTo('App\Sessions','session_id', 'id');
    }

    public function faculty_subject()
    {
        return $this->belongsTo('App\Subject','subject_id', 'id');
    }
}
