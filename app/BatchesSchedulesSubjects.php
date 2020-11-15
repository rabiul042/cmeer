<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BatchesSchedulesSubjects extends Model
{
    protected $table = 'batches_schedules_subjects';

    public function batches_schedules()
    {
        return $this->belongsTo('App\BatchesSchedules','schedule_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }
}
