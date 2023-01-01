<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctors_pasition extends Model
{
    use HasFactory;
    protected $fillable = [
        'en_pasition',
    'dt_pasition',

    ];
}
