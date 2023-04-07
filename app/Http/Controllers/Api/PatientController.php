<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\CityResource;
use App\Http\Resources\docFieldsResource;
use App\Http\Resources\DoctorClinicResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\FavouriteResource;
use App\Http\Resources\MedicalDoctorResource;
use App\Http\Resources\MedicalResource;
use App\Http\Resources\MedSearch;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\reservClinic;
use App\Http\Resources\ReviewResource;
use App\Models\City;
use App\Models\Clinic_review;
use App\Models\Doctor;
use App\Models\Doctor_clinic;
use App\Models\Favourite_doctor;
use App\Models\Medical_field;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
class PatientController extends BaseController
{
    public function review(Request $request)
    {
        // $userid = Auth::user()->id;
        $userid = auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'clinic_id' => 'required',
            'stars' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }
        try {
            $data = [
                'clinic_id' => $request->clinic_id,
                'user_id' => $userid,
                'stars' => $request->stars,
                'comment' => $request->comment,

            ];
            $review = Clinic_review::create($data);

            return $this->sendResponse(ReviewResource::make($review), 'U make review successfully.');

        } catch (\Exception$ex) {
            return $this->sendError($ex->getMessage(), 'Error happens!!');
        }

    }

    public function favourite(Request $request)
    {
        // $userid = Auth::user()->id;
        $userid = auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'clinic_id' => 'required',

        ]);

        if ($validator->fails()) {
            // return $this->convertErrorsToString($validator->messages());
            return $this->sendError($validator->messages());
        }
        try {
            $data = [
                'clinic_id' => $request->clinic_id,
                'user_id' => $userid,

            ];
            $favourite = Favourite_doctor::create($data);

            return $this->sendResponse(FavouriteResource::make($favourite), 'U make favourite successfully.');

        } catch (\Exception$ex) {
            return $this->sendError($ex->getMessage(), 'Error happens!!');
        }

    }
    public function removeFavourite(Request $request){
       // $userid = Auth::user()->id;
       $userid = auth('api')->user()->id;
       $validator = Validator::make($request->all(), [
           'clinic_id' => 'required',

       ]);

       if ($validator->fails()) {
        //    return $this->convertErrorsToString($validator->messages());
           return $this->sendError($validator->messages());
       }
       try {
           $data = [
               'clinic_id' => $request->clinic_id,
               'user_id' => $userid,

           ];
           $favourite = Favourite_doctor::where('clinic_id',$request->clinic_id)->where('user_id', $userid)->first();
if($favourite){
    $$favourite->delete();
    return $this->sendResponse(null, 'U remove favourite successfully.');

}

       } catch (\Exception$ex) {
           return $this->sendError($ex->getMessage(), 'Error happens!!');
       }
    }
public function getReservation(Request $request){
    $page=[];
    $userid = auth('api')->user()->id;

    // $validator = Validator::make($request->all(), [
    //     'clinic_id' => 'required',
    //     'reservation_date' => 'required',
    //     'time_from' => 'required',
    //     'time_to' => 'required',
    // ]);

    // if ($validator->fails()) {
    //     // return $this->convertErrorsToString($validator->messages());
    //     return $this->sendError($validator->messages());
    // }

    $clinic = Doctor_clinic::where('id', $request->get('clinic_id'))->first();
    $page['clinic_data'] = reservClinic::make($clinic);
    $page['appointment'] =[
        'reservation_date'=>$request->get('reservation_date'),
        'time_from'=>$request->get('time_from'),
        'time_to'=>$request->get('time_to'),
    ];
    return $this->sendResponse($page, "get all reserve data ");
}
    public function reservation(Request $request)
    {
        // $userid = Auth::user()->id;
        $userid = auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'clinic_id' => 'required',
            'reservation_date' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
        ]);

        if ($validator->fails()) {
            // return $this->convertErrorsToString($validator->messages());
            return $this->sendError($validator->messages());
        }
        try {
            $data = [
                'clinic_id' => $request->clinic_id,
                'patient_id' => $userid,
                'reservation_date' => $request->reservation_date,
                'time_from' => $request->time_from,
                'time_to' => $request->time_to,
                'other_flag' => $request->other_flag,
                'patient_name' => $request->patient_name,
                'patient_mobile' => $request->patient_mobile,
                'patient_address' => $request->patient_address,
                'reservation_status_id' => 1,

            ];
            $reserve = Reservation::create($data);

            return $this->sendResponse(ReservationResource::make($reserve), 'U make reservation successfully.');

        } catch (\Exception$ex) {
            return $this->sendError($ex->getMessage(), 'Error happens!!');
        }

    }

    public function showOldRreservation()
    {
        $userid = auth('api')->user()->id;
        $rows = Reservation::with('status')->where('patient_id', $userid)->whereDate('reservation_date', '<', now())->orWhereIn('reservation_status_id',[3,4])->orderBy("reservation_date", "Desc")->get();
        return $this->sendResponse(ReservationResource::collection($rows), 'All your reservations');
    }
    public function showNewRreservation()
    {
        $userid = auth('api')->user()->id;
        $rows = Reservation::with('status')->where('patient_id', $userid)->whereDate('reservation_date', '>=', now())->orderBy("reservation_date", "Desc")->get();
        return $this->sendResponse(ReservationResource::collection($rows), 'All your reservations');
    }

    public function cancelReservation(Request $request)
    {
        // $userid = Auth::user()->id;
        $userid = auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'reservation_id' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }
        try {

            $reserve = Reservation::where('id',$request->reservation_id)->first();
            if($reserve){
                $reserve->reservation_status_id=4;
                $reserve->save();
                return $this->sendResponse(ReservationResource::make($reserve), 'U  reservation Cancelles successfully.');

                        }else{
                            return $this->sendError(null, 'Error happens!!');
                        }

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), 'Error happens!!');
        }

    }


    public function search(Request $request){
        $search = '';
      $str=$request->get('str');
      $lower=$request->get('lower');
      $speciality=$request->get('speciality');
      $city=$request->get('city');
      $selectdays=$request->get('selectdays');
      $insurance=$request->get('insurance');
      $min_price=floatval($request->get('min_price'));
      $max_price=floatval($request->get('max_price'));
      $homeVisit=$request->get('homeVisit');
      $parkingSpace=$request->get('parkingSpace');
      $disableAccess=$request->get('disableAccess');


            $search = $str;

            $doctors =Doctor_clinic::select(['*'])->
            join('doctors', 'doctor_clinics.doctor_id', '=', 'doctors.id')
            ->join('insurance_types', 'doctor_clinics.insurance_type_id', '=', 'insurance_types.id')
            ->join('doctor_schedules', 'doctor_clinics.id', '=', 'doctor_schedules.clinic_id')
            ->join('doctor_feilds',  'doctor_feilds.doctor_id','=','doctors.id');


        if ($str) {

            $doctors=$doctors->where('doctor_clinics.name', 'LIKE', "%$str%")->orWhere('doctors.name', 'LIKE', "%$str%");

         }
         if ($speciality) {

            $doctors=$doctors->whereIn("doctor_feilds.medical_field_id", explode(',', $speciality));
         }
        if ($selectdays) {

            $doctors=$doctors->whereIn("doctor_schedules.days_id", explode(',', $selectdays));
         }
         if ($insurance) {

            $doctors=$doctors->where("insurance_types.id", $insurance);
         }

         if ($city) {

            $doctors=$doctors->where("city_id",$city);
         }

         if ($min_price && $max_price) {

            $doctors->whereBetween('visit_fees', [$min_price, $max_price]);
         }
         if ($min_price) {

            $doctors->where('visit_fees','>=', $min_price);
         }
         if ($max_price) {

            $doctors->where('visit_fees','<=', $max_price);
         }
         if ($homeVisit) {

            $doctors=$doctors->where("home_visit_allowed", $homeVisit);
         }
         if ($parkingSpace) {

            $doctors=$doctors->where("parking_allowed", $parkingSpace);
         }
         if ($disableAccess) {

            $doctors=$doctors->where("disability_allowed", $disableAccess);
         }
         if ($lower) {
if($lower == 1){
    $doctors=$doctors->orderby("visit_fees",'Desc');
}else{
    $doctors=$doctors->orderby("visit_fees",'asc');
}

         }
        $doctors=$doctors->get();
         return $doctors;
            // return $this->sendResponse($doctors, 'All Search result Retrieved  Successfully');
            return $this->sendResponse(DoctorClinicResource::collection($doctors), 'All Search result Retrieved  Successfully');

    }

public function favoriteDoctors(){
    $userid = auth('api')->user()->id;
$ids=Favourite_doctor::where('user_id',$userid)->pluck('clinic_id');
$doctors =Doctor_clinic::whereIn('id',$ids)->get();
return $this->sendResponse(DoctorClinicResource::collection($doctors), 'All vafourite doctors result Retrieved  Successfully');

}

public function searchInputs(){
    $page = [];
    $cities=City::all();
    $page['cities']=CityResource::collection($cities);
    $specialists = Medical_field::get();
    if (App::getLocale() == "en") {
    $sort=[
        0 => ["id" =>0 ,"name" => "lower cost"],
        1 => ["id" => 1, "name" => "upper"]
      ];
    }else{
        $sort=[
            0 => ["id" =>0 ,"name" => "Niedrigere Kosten"],
            1 => ["id" => 1, "name" => "obere Kosten"]
          ];
    }
    $page['sort'] = $sort;
    $page['specialists'] =MedSearch::collection($specialists);

    return $this->sendResponse($page, "get all  data ");
}

}
