<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'clinic_id',
        'reservation_status_id',
        'notes',
        'reservation_date',
        'time_from',
        'time_to',
        'other_flag',
        'patient_name',
        'patient_mobile',
        'patient_address',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class,'patient_id');
    }


    public function clinic()
    {
        return $this->belongsTo(Doctor_clinic::class,'clinic_id');
    }

    public function status()
    {
        return $this->belongsTo(Reservation_status::class,'reservation_status_id');
    }

}
