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

}
