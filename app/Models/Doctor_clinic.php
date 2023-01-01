<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_clinic extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'city_id',
        'phone',
        'en_street',
        'dt_street',
        'postal_code',
        'google_map',
        'parking_allowed',
        'home_visit_allowed',
        'disability_allowed',
        'clinic_status_id',
        'insurance_type_id',
        'visit_fees',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }


}
