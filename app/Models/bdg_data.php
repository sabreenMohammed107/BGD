<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bdg_data extends Model
{
    use HasFactory;
    protected $fillable = [
        'logo',
        'home_video',
        'home_tutorial',
        'home_dt_video',
        'home_dt_tutorial',

    ];
}
