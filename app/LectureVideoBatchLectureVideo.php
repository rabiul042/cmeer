<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureVideoBatchLectureVideo extends Model
{
    protected $table = 'lecture_video_batch_lecture_video';

    public function video()
    {
        return $this->belongsTo('App\LectureVideo','lecture_video_id','id');
        //return $this->hasMany('App\LectureVideo',['year','session_id','institute_id','course_id','topic_id'], ['year','session_id','institute_id','course_id','topic_id']);
    }

    public $timestamps = false;

    
}
