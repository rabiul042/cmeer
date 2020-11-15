<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureVideoTopics extends Model
{
    protected $table = 'lecture_video_topics';

    public function topic()
    {
        return $this->belongsTo('App\Topics','topic_id','id');
        //return $this->hasMany('App\LectureVideo',['year','session_id','institute_id','course_id','topic_id'], ['year','session_id','institute_id','course_id','topic_id']);
    }

    public $timestamps = false;

    
}
