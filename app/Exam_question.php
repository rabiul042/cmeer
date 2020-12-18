<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_question extends Model
{
    protected $table = 'exam_question';

    public function exam()
    {
        return $this->belongsTo('App\Exam', 'exam_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo('App\Question', 'question_id', 'id');
    }
}
