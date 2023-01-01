<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boarding extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'title_en',
        'title_dt',
        'text_en',
        'text_dt',
        'order',

    ];
}
