<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_feild extends Model
{
    use HasFactory;

    public function medical(){
        return $this->belongsTo(Medical_field::class,'medical_field_id');
      }

      public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
      }


}
