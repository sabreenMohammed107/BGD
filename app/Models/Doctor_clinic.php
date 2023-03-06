<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\DayNew as DayNew;
class Doctor_clinic extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'doctor_id',
        'city_id',
        'phone',
        'en_street',
        'dt_street',
        'postal_code',
        'google_map',
        'parking_allowed',
        'home_visit_allowed',
        'disability_allowed',
        'clinic_status_id',
        'insurance_type_id',
        'visit_fees',
    ];
    public function insurance()
    {
        return $this->belongsTo(Insurance_type::class, 'insurance_type_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
    public function review(){
        return $this->hasMany(Clinic_review::class,'clinic_id','id');
      }
    public function avgRating()
    {
        return round($this->review()->avg('stars'),1);
    }

    public function days(){
        return $this->hasMany(Doctor_schedule::class,'clinic_id','id');
      }

      protected $appends = ['next_day','next_time','clinic_name'];

      public function getClinicNameAttribute()
{
    return $this->name;
}
      public function getNextDayAttribute()
    {

        $day = Carbon::now()->dayOfWeek;
$schad = Doctor_schedule::where('clinic_id',  $this->id)->where('days_id', '>=', $day)->min('days_id');


         $avDay=DayNew::where('id',$schad)->first();
   if($avDay){
    if($day == $schad){
        return 'today';
    }else{
        return $avDay->en_day;
    }

   }

   else{
    return '';
   }

    }


    public function getNextTimeAttribute()
    {

        $day = Carbon::now()->dayOfWeek;
        $timeAv=Doctor_schedule::where('clinic_id',  $this->id)->where('days_id', '>=', $day)->orderBy('days_id', 'asc')->first();

return $timeAv;
    }

    public function fields()
    {
        return $this->belongsToMany(Medical_field::class, 'doctor_feilds');
    }


}
