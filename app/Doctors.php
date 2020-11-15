<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Doctors extends Authenticatable
{
    use Notifiable;
    use HasRoles;


    protected $table = 'doctors';

    public function doctorcourses()
    {
        return $this->hasMany('App\DoctorsCourses','doctor_id','id');
    }

    public function medicalcolleges()
    {
        return $this->belongsTo('App\MedicalColleges','medical_college_id','id');
    }

    public function present_thana()
    {
        return $this->belongsTo('App\Upazilas','present_upazila_id','id');
    }

    public function present_upazila()
    {
        return $this->belongsTo('App\Upazilas','present_upazila_id','id');
    }

    public function present_district()
    {
        return $this->belongsTo('App\Districts','present_district_id','id');
    }

    public function present_division()
    {
        return $this->belongsTo('App\Divisions','present_division_id','id');
    }

    public function permanent_thana()
    {
        return $this->belongsTo('App\Upazilas','permanent_upazila_id','id');
    }

    public function permanent_upazila()
    {
        return $this->belongsTo('App\Upazilas','permanent_upazila_id','id');
    }

    public function permanent_district()
    {
        return $this->belongsTo('App\Districts','permanent_district_id','id');
    }

    public function permanent_division()
    {
        return $this->belongsTo('App\Divisions','permanent_division_id','id');
    }

    public function educations()
    {
        return $this->hasMany('App\DoctorEducations','doctor_id','id');
    }
}
