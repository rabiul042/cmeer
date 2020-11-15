<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BatchesSchedulesSlots extends Model
{
    protected $table = 'batches_schedules_slots';

    public function slot()
    {
        return $this->belongsTo('App\BatchesSchedulesSlotTypes','slot_type','slot_type');
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }
}
