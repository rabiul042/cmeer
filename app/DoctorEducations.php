<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorEducations extends Model
{

    protected $table = 'doctors_education';

    public function medical_college()
    {
        return $this->belongsTo('App\MedicalColleges','board','id');
    }

}
