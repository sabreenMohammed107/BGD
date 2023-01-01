<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite_doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    'clinic_id',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function clinic()
    {
        return $this->belongsTo(Doctor_clinic::class,'clinic_id');
    }
}
