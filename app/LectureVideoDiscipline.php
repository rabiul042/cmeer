<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureVideoDiscipline extends Model
{
    //protected $table = 'lecture_video_links';
    protected $table = 'lecture_video_discipline';

    public function discipline()
    {
        //return $this->belongsToMany('App\LectureVideo');
        return $this->belongsTo('App\Subjects','subject_id','id');
    }

    public function lecture_video()
    {
        //return $this->belongsToMany('App\LectureVideo');
        return $this->belongsTo('App\LectureVideo','lecture_video_id','id');
    }    
    
}
