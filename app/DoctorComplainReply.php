<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorComplainReply extends Model
{
    protected $table = 'doctor_complain_reply';

    // public function doctorname()
    // {
    //     return $this->belongsTo('App\Doctors','doctor_id','id');
    // }

    public function doctor()
    {
        return $this->belongsTo('App\Doctors','doctor_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    
}
