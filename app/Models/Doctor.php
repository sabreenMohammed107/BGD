<?php

namespace App\Models;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Doctor extends Authenticatable
{
    use Notifiable;

    protected $guard = 'doctor';

    protected $fillable = [
        'name', 'email', 'password','mobile'
        ,
        'img',
        'en_overview',
        'dt_overview',
        'en_brief',
        'dt_brief',
        'licence_file',
        'verified',
        'medical_field_id',
        'doctor_position_id',
        'doctor_status_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
