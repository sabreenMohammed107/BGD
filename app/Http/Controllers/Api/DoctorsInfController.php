<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\DocorProfileResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\HomeDoctorResource;
use App\Http\Resources\MedicalResource;
use App\Http\Resources\scadualInfoResource;
use App\Models\bdg_data;
use App\Models\Doctor;
use App\Models\Doctor_clinic;
use App\Models\Doctor_feild;
use App\Models\Doctor_schedule;
use App\Models\Favourite_doctor;
use App\Models\Medical_field;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class DoctorsInfController extends BaseController
{

    public function doctorsInf()
    {
        $page = [];
        // $specialists = Medical_field::all();
        $specialistsIds = Doctor_feild::pluck('medical_field_id');
        $specialists = Medical_field::whereIn('id', $specialistsIds)->get();
        $specialists = Medical_field::get();

        $page['specialists'] = MedicalResource::collection($specialists);
        $doctors = Doctor::with(['medicines'])->take(5)->orderBy("id", "Desc")->get();
        $newDocotorClinic=Doctor_clinic::take(5)->orderBy("id", "Desc")->get();
        $page['latest_doctors'] = HomeDoctorResource::collection($newDocotorClinic);
        // $page['latest_doctors'] = DoctorResource::collection($doctors);
        //patient - reservation
        // $userid = auth('api')->user()->id;
        $userid =Auth::user()->id;
        $current_date = Carbon::now();
        $date = Carbon::parse($current_date)->format('Y-m-d');
        $reservations = Reservation::where('patient_id', $userid)->where('reservation_date', '>=', $date)->whereIn('reservation_status_id', [1, 5])->orderBy("reservation_date", "asc")->get();
        $page['schedule'] = scadualInfoResource::collection($reservations);
        $bdgData = bdg_data::where('id', 1)->first();
        $page['vedio'] = $bdgData->home_video;
        $page['bdgTutoril'] = $bdgData->home_tutorial;
        return $this->sendResponse($page, "get all home data ");
    }

    public function docProfile($id)
    {
        $page = [];
        $clinic = Doctor_clinic::where('id', $id)->first();
        $page['clinic_data'] = DocorProfileResource::make($clinic);
    //    $doctor_schedule=[];
$rr=[];
        $schadDys = Doctor_schedule::where('clinic_id', $id)->get();

        $start_date = Carbon::now();
        for ($i = 1; $i <= 15; $i++) {

            foreach ($schadDys as $schad) {
                $day =$start_date->dayOfWeek;
dd($start_date->dayOfWeek);
                if ($day == $schad->days_id) {
                    // echo  $start_date;
                    if(App::getLocale()=="en"){
                    $doctor_schedule[$i] = (object)  [
                        'date' => $start_date->format('Y-m-d') ,
                    'day' => $schad->daName->en_day ?? '',
                    'from' => $schad->time_from,
                    'to' => $schad->time_to,
                   ];
                }else{
    $doctor_schedule[$i] = (object)  [
        'date' => $start_date->format('Y-m-d') ,
    'day' => $schad->daName->dt_day ?? '',
    'from' => $schad->time_from,
    'to' => $schad->time_to,
   ];
}

                }
                // $doctor_schedule['schedule'] = $doctor_schedule;

            }
        //    echo $start_date;

                        $start_date = $start_date->addDays(1);

        }

        $page['schedule'] = $doctor_schedule;

        //favorite
        $user=Auth::user();

        if($user){
            $ff=Favourite_doctor::where('clinic_id',$id)->where('user_id',$user->id)->first();
            if($ff){
                $page['favorite'] = true;
            }else{
                $page['favorite'] = false;
            }

        }
        return $this->sendResponse($page, "get all home data ");

    }
}
