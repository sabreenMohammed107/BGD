<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical_field extends Model
{
    use HasFactory;
    protected $fillable = [
        'field_enname',
    'field_dtname',
    'field_img',
    'field_enoverview',
    'field_dtoverview',
    'order',
    ];


    public function subFields()
    {
        return $this->hasMany(Medical_sub_field::class);
    }

    public function clinics()
    {
        return $this->hasManyThrough(
            Doctor_clinic::class,
            Doctor_feild::class,
            'medical_field_id', // Foreign key on doctors table...
            'doctor_id', // Foreign key on clinic table...
            'id', // Local key on medical table...
            'id' // Local key on doctor table...
        );
    }


    public function repliesCount() {
        return $this->clinics()->selectRaw('medical_field_id, count(*) as doctor_count')
                        ->groupBy('medical_field_id');
    }




    public function doctors()
    {

        return $this->belongsToMany(Doctor::class, 'doctor_feilds')
        ->withTimestamps();
    }

}
