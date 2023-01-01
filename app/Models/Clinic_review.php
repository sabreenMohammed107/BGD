<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic_review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'clinic_id',
        'stars',
        'comment',
        'active',
        'comment_date',
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
