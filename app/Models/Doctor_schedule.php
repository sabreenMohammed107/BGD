<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'clinic_id',
        'days_id',
        'time_from',
        'time_to',
        'active',

    ];
}
