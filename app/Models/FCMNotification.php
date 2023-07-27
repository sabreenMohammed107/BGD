<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FCMNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_dt',
        'title_en',
        'body_dt',
        'body_en',
        'user_id',
    ];

}
