<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Clinic_gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'clinic_id',
    'image',
    'active'

    ];

    public function clinic()
    {
        return $this->belongsTo(Doctor_clinic::class,'clinic_id');
    }
}
