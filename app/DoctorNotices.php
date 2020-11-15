<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorNotices extends Model
{
    protected $table = 'doctor_notice';

    public function doctorname()
    {
        return $this->belongsTo('App\Doctors','doctor_id','id');
    }

    
    
}
