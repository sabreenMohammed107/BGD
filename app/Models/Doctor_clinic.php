<?php

namespace App\Models;

use App\Http\Resources\docFieldsResource;
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
        'en_reservation_notes',
        'dt_reservation_notes'
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

      protected $appends = ['next_day','next_time','clinic_name','clinic_id'];

      public function getClinicNameAttribute()
{
    return $this->name;
}

public function getClinicIdAttribute()
{
    return $this->id;
}
      public function getNextDayAttribute()
    {

        $day = Carbon::now()->dayOfWeek;
// $schad = Doctor_schedule::where('clinic_id',  $this->id)->where('days_id', '>=', $day)->min('days_id');
$schad = Doctor_schedule::where('clinic_id',  $this->id)->min('days_id');


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
    public function getSchdualAttribute()
    {
        $start_date=Carbon::now();
        $end_date=Carbon::now()->addDays(15);
        $day = Carbon::now()->dayOfWeek;
        $schadDys = Doctor_schedule::where('clinic_id',  $this->id)->pluck('days_id');
        //$schadDys = Doctor_schedule::where('clinic_id',  $this->id)->where('days_id', '>=', $day)->pluck('days_id');


    for($i=$start_date;$i<$end_date;$i++ ){

        foreach($schadDys as $schad) {
if($i->dayOfWeek == $schad){

}
        }

    }

}
    public function getNextTimeAttribute()
    {

        $day = Carbon::now()->dayOfWeek;
        // $timeAv=Doctor_schedule::where('clinic_id',  $this->id)->where('days_id', '>=', $day)->orderBy('days_id', 'asc')->first();
        $timeAv=Doctor_schedule::where('clinic_id',  $this->id)->orderBy('days_id', 'asc')->first();

return $timeAv;
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class, 'favourite_doctors')
        ->withTimestamps();
    }



}
