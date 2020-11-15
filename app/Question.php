<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

    public function question_answers()
    {
        return $this->hasMany('App\Question_ans','question_id','id');
    }

}
