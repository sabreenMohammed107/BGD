<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\MedicalResource;
use App\Http\Resources\scadualInfoResource;
use App\Models\bdg_data;
use App\Models\Doctor;
use App\Models\Doctor_clinic;
use App\Models\Doctor_feild;
use App\Models\Doctor_schedule;
use App\Models\Medical_field;
use App\Models\Reservation;
use Carbon\Carbon;

class DoctorsInfController extends BaseController
{


    public function doctorsInf(){
        $page=[];
        // $specialists = Medical_field::all();
        $specialistsIds = Doctor_feild::pluck('medical_field_id');
        $specialists = Medical_field::whereIn('id',$specialistsIds)->get();
        $page['specialists']=MedicalResource::collection($specialists);
        $doctors=Doctor::take(5)->orderBy("id", "Desc")->get();
        $page['latest_doctors']=DoctorResource::collection($doctors);
        //patient - reservation
        $userid = auth('api')->user()->id;
        $current_date = Carbon::now();
        $date = Carbon::parse($current_date)->format('Y-m-d');
        $reservations=Reservation::where('patient_id',$userid)->where('reservation_date','>=',$date)->whereIn('reservation_status_id',[1,5])->orderBy("reservation_date", "asc")->get();
        $page['schedule']=scadualInfoResource::collection($reservations) ;
$bdgData =bdg_data::where('id',1)->first();
      $page['vedio']=$bdgData->home_video;
        $page['bdgTutoril']= $bdgData->home_tutorial;
        return $this->sendResponse( $page, "get all home data ");
    }
}
