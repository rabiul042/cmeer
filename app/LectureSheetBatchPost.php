<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureSheetBatchPost extends Model
{
    protected $table = 'lecture_sheet_batch_post';

    public function lecture_sheets()
    {
        //return $this->belongsToMany('App\LectureSheet');
        return $this->hasMany('App\LectureSheet',['year','session_id','institute_id','course_id','topic_id'], ['year','session_id','institute_id','course_id','topic_id']);
    }

    public function lecture_sheet_post()
    {
        return $this->belongsTo('App\LectureSheetPost','lecture_sheet_post_id', 'id');
    }



    public $timestamps = false;
}
