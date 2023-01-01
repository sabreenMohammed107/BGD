<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = [
        'en_question',
    'dt_question',
    'en_answer',
    'dt_answer',
    'active',
    ];
}
