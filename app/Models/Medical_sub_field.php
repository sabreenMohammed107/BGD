<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical_sub_field extends Model
{
    use HasFactory;
    protected $fillable = [
        'field_enname',
    'field_dtname',
    'field_img',
    'medical_field_id',
    'field_enoverview',
    'field_dtoverview',
    'order',
    ];


    public function field()
    {
        return $this->belongsTo(Medical_field::class);
    }

}
