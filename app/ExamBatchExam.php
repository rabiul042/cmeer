<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamBatchExam extends Model
{
    protected $table = 'exam_batch_exam';

    public function exam()
    {
        return $this->belongsTo('App\Exam','exam_id','id');
    }

    public function batch_exam()
    {
        return $this->belongsTo('App\ExamBatch','exam_batch_id','id');
    }

    public $timestamps = false;

    
}
