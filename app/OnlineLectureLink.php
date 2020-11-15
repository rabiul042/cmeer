<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineLectureLink extends Model
{
    protected $table = 'online_lecture_links';

    public function online_lecture_address()
    {
        return $this->belongsTo('App\OnlineLectureAddress','lecture_address_id', 'id');
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

    public function session()
    {
        return $this->belongsTo('App\Sessions','session_id', 'id');
    }

    public function batch()
    {
        return $this->belongsTo('App\Batches','batch_id', 'id');
    }

    public function faculty_subject()
    {
        return $this->belongsTo('App\Subject','subject_id', 'id');
    }
}
