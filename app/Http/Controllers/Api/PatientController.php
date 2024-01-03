<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\CityResource;
use App\Http\Resources\DayResource;
use App\Http\Resources\DoctorClinicResource;
use App\Http\Resources\FavouriteResource;
use App\Http\Resources\MedSearch;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\reservClinic;
use App\Http\Resources\ReviewResource;
use App\Models\City;
use App\Models\Clinic_review;
use App\Models\DayNew;
use App\Models\Doctor;
use App\Models\Doctor_clinic;
use App\Models\Doctor_schedule;
use App\Models\Favourite_doctor;
use App\Models\Medical_field;
use App\Models\Reservation;
use App\Notifications\PatientReservationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class PatientController extends BaseController
{
    public function review(Request $request)
    {
        // $userid = auth('api')->user()->id;
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

            return $this->sendResponse(ReviewResource::make($review), __("langMessage.make_review"));

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), __("langMessage.error_happens"));
        }

    }

    public function favourite(Request $request)
    {
        // $userid = auth('api')->user()->id;
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

            return $this->sendResponse(FavouriteResource::make($favourite), __("langMessage.make_fav"));

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), __("langMessage.error_happens"));
        }

    }
    public function removeFavourite(Request $request)
    {
        $userid = auth('api')->user()->id;
        //    $userid = auth('api')->user()->id;
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
            $favourite = Favourite_doctor::where('clinic_id', $request->clinic_id)->where('user_id', $userid)->first();
            if ($favourite) {

                $favourite->delete();

                return $this->sendResponse([], __("langMessage.remove_fav"));

            }

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), __("langMessage.error_happens"));
        }
    }
    public function getReservation(Request $request)
    {
        $page = [];
        $userid = auth('api')->user()->id;

        $clinic = Doctor_clinic::where('id', $request->get('clinic_id'))->first();
        $page['clinic_data'] = reservClinic::make($clinic);
        $page['appointment'] = [
            'reservation_date' =>$request->get('reservation_date'),
            'time_from' => $request->get('time_from'),
            'time_to' => $request->get('time_to'),
        ];

        return $this->sendResponse($page, __("langMessage.reserve_data"));
    }
    public function reservation(Request $request)
    {
        // $userid = auth('api')->user()->id;
        $userid = auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'clinic_id' => 'required',
            'reservation_date' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            // 'patient_mobile' =>  ['nullable','string','min:10','max:14','regex:/^([0-9\s\-\+\(\)]*)$/'],
        ]);

        if ($validator->fails()) {
            // return $this->convertErrorsToString($validator->messages());
            return $this->sendError($validator->messages());
        }
        try {
            $time = strtotime($request->reservation_date);

            $newformat= date('Y-m-d',$time);
            $data = [
                'clinic_id' => $request->clinic_id,
                'patient_id' => $userid,
                'reservation_date' =>$newformat,
                'time_from' => $request->time_from,
                'time_to' => $request->time_to,
                'other_flag' => $request->other_flag,
                'patient_name' => $request->patient_name,
                'patient_mobile' => $request->patient_mobile,
                'patient_address' => $request->patient_address,
                'reservation_status_id' => 1,

            ];
            $reserve = Reservation::create($data);
//send notification to the doctor
//get doctor
            $clinic = Doctor_clinic::where('id', $request->clinic_id)->first();
            if ($clinic) {
                $offerData = [
                    'name' => $request->patient_name ?? '',
                    'body' => 'has set an appointment',
                    'date' => $request->reservation_date,
                    'time' => $request->time_from,

                ];

                $doc = Doctor::where('id', $clinic->doctor_id)->first();

                $doc->notify(new PatientReservationNotification($offerData));
            }

//end notification

            return $this->sendResponse(ReservationResource::make($reserve), __("langMessage.make_reserve"));

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), __("langMessage.error_happens"));
        }

    }

    public function showOldRreservation()
    {
        $userid = auth('api')->user()->id;

        // $rows = Reservation::where('patient_id', '=', $userid)
        //     ->whereDate('reservation_date', '<', now())
        //     ->WhereIn('reservation_status_id', [3, 4])
        //     ->orderBy("reservation_date", "Desc")->get();

             $rows = Reservation::where('patient_id', '=', $userid)
            ->where(function ($query){
                $query->whereDate('reservation_date', '<', now());
                $query->orWhereIn('reservation_status_id', [3, 4,2]);
            })->orderBy("reservation_date", "Desc")->get();
        return $this->sendResponse(ReservationResource::collection($rows), __("langMessage.old_reserve"));

    }
    public function showNewRreservation()
    {
        $userid = auth('api')->user()->id;
        $rows = Reservation::where('patient_id', $userid)
            ->whereNotIn('reservation_status_id', [3, 4,2])
            ->whereDate('reservation_date', '>=', now())
            ->orderBy("reservation_date", "Desc")->get();

        return $this->sendResponse(ReservationResource::collection($rows), __("langMessage.new_reservations"));
    }

    public function cancelReservation(Request $request)
    {
        // $userid = auth('api')->user()->id;
        $userid = auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'reservation_id' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }
        try {

            $reserve = Reservation::where('id', $request->reservation_id)->first();
            if ($reserve) {
                $reserve->reservation_status_id = 4;
                $reserve->save();
                //send notification to the doctor
//get doctor
                $clinic = Doctor_clinic::where('id', $reserve->clinic_id)->first();
                if ($clinic) {
                    $offerData = [
                        'name' => $reserve->patient_name ?? '',
                        'body' => 'Cancelled his appointment',
                        'date' => $reserve->reservation_date,
                        'time' => $reserve->time_from,

                    ];

                    $doc = Doctor::where('id', $clinic->doctor_id)->first();
                    $doc->notify(new PatientReservationNotification($offerData));
                }

//end notification

                return $this->sendResponse(ReservationResource::make($reserve), __("langMessage.Cancelled_reservations"));

            } else {
                return $this->sendError(null, __("langMessage.error_happens"));
            }

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), __("langMessage.error_happens"));
        }

    }
    public function searchOld(Request $request)
    {
        $str = $request->get('str');
        $doctors = Doctor_clinic::select('doctor_clinics.*')->
        join('doctors', 'doctor_clinics.doctor_id', '=', 'doctors.id')
        ->join('insurance_types', 'doctor_clinics.insurance_type_id', '=', 'insurance_types.id')
        ->join('doctor_schedules', 'doctor_clinics.id', '=', 'doctor_schedules.clinic_id')
        ->join('doctor_feilds', 'doctor_feilds.doctor_id', '=', 'doctor_clinics.doctor_id');

    if ($request->get('speciality')) {
        $r = json_decode($request->get('speciality'), true);
        if (count($r) > 0) {

            $doctors = $doctors->whereIn("doctor_feilds.medical_field_id", $r);
        }

    }

    if ($request->get('selectdays')) {
        $s = json_decode($request->get('selectdays'), true);
        if (count($s) > 0) {
            $doctors = $doctors->whereIn("doctor_schedules.days_id", $s);
        }
    }


        if ($request->get('insurance') == 1) { //public
            $doctors = $doctors->where("insurance_types.id", 1);

        } else if ($request->get('insurance') == 0) { //private

            $doctors = $doctors->where("insurance_types.id", 2);

        }
        else{
            $doctors = $doctors->whereIn("insurance_types.id", [1,2]);

        }


            if (floatval($request->get('min_price'))) {

                $doctors->where("insurance_types.id", 2)->where('doctor_clinics.visit_fees', '>=',floatval($request->get('min_price')));
            }
            if (floatval($request->get('max_price'))) {

                $doctors->where("insurance_types.id", 2)->where('doctor_clinics.visit_fees', '<=', floatval($request->get('max_price')));
            }





    // if (!empty($str)) {
    //     $doctors->where(function ($q) use ($str) {
    //         $q->where('doctor_clinics.name', 'like', '%' . $str . '%')
    //             ->orWhereHas('doctor', function ($q) use ($str) {
    //                 $q->where('doctors.name', 'like', '%' . $str . '%');
    //             });
    //     });
    // }
    $doctors = $doctors->groupBy('doctor_clinics.id')->get();


    return $this->sendResponse(DoctorClinicResource::collection($doctors), __("langMessage.search_result"));

    }
    public function search(Request $request)
    {
        $search = '';
        $str = $request->get('str');
        $lower = $request->get('lower');
        $speciality = $request->get('speciality');
        $city = $request->get('city');
        $selectdays = $request->get('selectdays');
        $insurance = $request->get('insurance');
        $min_price = floatval($request->get('min_price'));
        $max_price = floatval($request->get('max_price'));
        $homeVisit = $request->get('homeVisit');
        $parkingSpace = $request->get('parkingSpace');
        $disableAccess = $request->get('disableAccess');
// $sort_name=$request->get('sort_name');

        $search = $str;

        $doctors = Doctor_clinic::select('doctor_clinics.*')
        ->join('doctors', 'doctor_clinics.doctor_id', '=', 'doctors.id')
        ->join('insurance_types', 'doctor_clinics.insurance_type_id', '=', 'insurance_types.id')
        ->join('doctor_schedules', 'doctor_clinics.id', '=', 'doctor_schedules.clinic_id')
        ->join('doctor_feilds', 'doctor_feilds.doctor_id', '=', 'doctor_clinics.doctor_id');

        if ($request->get('speciality')) {
            $r = json_decode($request->get('speciality'), true);
            if (count($r) > 0) {

                $doctors = $doctors->whereIn("doctor_feilds.medical_field_id", $r);
            }

        }
        if ($request->get('selectdays')) {
            $s = json_decode($request->get('selectdays'), true);
            if (count($s) > 0) {
                $doctors = $doctors->whereIn("doctor_schedules.days_id", $s);
            }
        }

        if ($request->has('insurance')) {
            if ($request->get('insurance') == "public") { //public
                $doctors = $doctors->where("insurance_types.id", 1);

            } else if ($request->get('insurance') == "private") { //private
                $doctors = $doctors->where("insurance_types.id", 2);
                if ($min_price) {

                    $doctors->where('doctor_clinics.visit_fees', '>=', $min_price);
                }
                if ($max_price) {

                    $doctors->where('doctor_clinics.visit_fees', '<=', $max_price);
                }
            }else{
                $doctors = $doctors->whereIn("insurance_types.id", [1,2]);
            }

        }

        if ($request->get('city')) {

            $doctors = $doctors->where("city_id", $request->get('city'));
        }

        //  if ($min_price && $max_price) {

        //     $doctors->whereBetween('visit_fees', [$min_price, $max_price]);
        //  }

        if ($homeVisit) {

            $doctors = $doctors->where("home_visit_allowed", $homeVisit);
        }
        if ($parkingSpace) {

            $doctors = $doctors->where("parking_allowed", $parkingSpace);
        }
        if ($disableAccess) {

            $doctors = $doctors->where("disability_allowed", $disableAccess);
        }
        //  if ( $insurance == 0) {

        // }

        if (!empty($str)) {
            $doctors->where(function ($q) use ($str) {
                $q->where('doctor_clinics.name', 'like', '%' . $str . '%')
                    ->orWhereHas('doctor', function ($q) use ($str) {
                        $q->where('doctors.name', 'like', '%' . $str . '%');
                    });
            });
        }
        if ($request->has('lower')) {
            if ($lower == 1) {
                $doctors = $doctors->where("insurance_types.id", 2)->orderBy("doctor_clinics.visit_fees", 'Desc');
            } else if ($lower == 2) {
                $doctors = $doctors->orderBy("doctor_clinics.name", 'asc');
            } else if ($lower == 3) {
                $doctors = $doctors->orderBy("doctor_clinics.name", 'desc');
            } else if ($lower == 4) {

                $weekMap = [
                    6 => 1,
                    0 => 2,
                    1 => 3,
                    2 => 4,
                    3 => 5,
                    4 => 6,
                    5 => 7,
                ];

                $weekdd = collect([
                    Carbon::now()->dayOfWeek => Carbon::now(),
                    Carbon::now()->addDays(1)->dayOfWeek => Carbon::now()->addDays(1),
                    Carbon::now()->addDays(2)->dayOfWeek => Carbon::now()->addDays(2),
                    Carbon::now()->addDays(3)->dayOfWeek => Carbon::now()->addDays(3),
                    Carbon::now()->addDays(4)->dayOfWeek => Carbon::now()->addDays(4),
                    Carbon::now()->addDays(5)->dayOfWeek => Carbon::now()->addDays(5),
                    Carbon::now()->addDays(6)->dayOfWeek => Carbon::now()->addDays(6),
                ]);

                $resultCollection = $weekdd->keyBy(function ($item, $key) use ($weekMap) {
                    return isset($weekMap[$key]) ? $weekMap[$key] : $key;
                });

                $dayOfTheWeek = Carbon::now()->dayOfWeek;
                $dFake = $weekMap[$dayOfTheWeek];
                $weekday = $resultCollection[$dFake];

                // $doctorsMapAfter = $doctors->where('doctor_schedules.days_id', '>=', $dFake)
                //     ->orderBy("doctor_schedules.days_id", 'asc')
                //     ->groupBy('doctor_clinics.id')->get();

                // $doctorsMapBefore = $doctors->where('doctor_schedules.days_id', '<', $dFake)
                //     ->orderBy("doctor_schedules.days_id", 'asc')
                //     ->groupBy('doctor_clinics.id')->get();


                //get days

                //    $doctors= $doctorsMapAfter->merge($doctorsMapBefore);
                // return $this->sendResponse(DoctorClinicResource::collection($doctors), 'All Search result Retrieved  Successfully');
// new testing
// return $dFake;
                // $scadsaft = Doctor_schedule::where('days_id', '>=', $dFake)->orderBy("days_id", 'asc')->pluck('id');
                // $scadsbef = Doctor_schedule::where('days_id', '<', $dFake)->orderBy("days_id", 'asc')->pluck('id');
                // $doctorsTest = $scadsaft->merge($scadsbef);
                // $doctors = Doctor_clinic::select('doctor_clinics.*')->
                //     join('doctors', 'doctor_clinics.doctor_id', '=', 'doctors.id')
                //     ->join('insurance_types', 'doctor_clinics.insurance_type_id', '=', 'insurance_types.id')
                //     ->join('doctor_schedules', 'doctor_clinics.id', '=', 'doctor_schedules.clinic_id')
                //     ->join('doctor_feilds', 'doctor_feilds.doctor_id', '=', 'doctor_clinics.doctor_id')
                //     ->whereIn("doctor_schedules.id", $doctorsTest)->orderBy("doctor_schedules.days_id", 'asc')->groupBy('doctor_clinics.id')->get();

                $doctorsBefore =$doctors->where("doctor_schedules.days_id", "<", $dFake)
                    ->orderBy("doctor_schedules.days_id", 'asc')
                    ->get();

                $doctorsAfter =$doctors->where("doctor_schedules.days_id", ">=", $dFake)
                    ->orderBy("doctor_schedules.days_id", 'asc')
                    ->get();

                    //sabreen
                $mergedDoctors = $doctorsAfter->merge($doctorsBefore);
                // ->unique('id')->values();
                // dd($mergedDoctors);
                $uniqueDoctors = collect([]);

                foreach ($mergedDoctors as $doctor) {
                    // $exists = $uniqueDoctors->first(function ($item) use ($doctor) {
                    //     return $item->id === $doctor->id;
                    // });

                    // if (!$exists) {
                        $uniqueDoctors->push($doctor);
                    // }
                }


                return $this->sendResponse(DoctorClinicResource::collection($uniqueDoctors), __("langMessage.search_result"));
            } else {
                $doctors = $doctors->orderBy("doctor_clinics.visit_fees", 'asc');
            }
        }


        $doctors = $doctors->groupBy('doctor_clinics.id')->get();

        //  return $doctors;
        //
        // return $this->sendResponse($doctors, 'All Search result Retrieved  Successfully');
        return $this->sendResponse(DoctorClinicResource::collection($doctors), __("langMessage.search_result"));

    }

    public function favoriteDoctors()
    {
        $userid = auth('api')->user()->id;
        $ids = Favourite_doctor::where('user_id', $userid)->pluck('clinic_id');
        $doctors = Doctor_clinic::whereIn('id', $ids)->get();

        return $this->sendResponse(DoctorClinicResource::collection($doctors), __("langMessage.vafourite_result"));

    }

    public function searchInputs()
    {
        $page = [];
        $cities = City::all();
        $page['cities'] = CityResource::collection($cities);
        $specialists = Medical_field::get();
        if (App::getLocale() == "en") {
            $sort = [
                0 => ["id" => 0, "name" => "lower cost"],
                1 => ["id" => 1, "name" => "Higher Cost"],
                2 => ["id" => 2, "name" => "Name A to Z"],
                3 => ["id" => 3, "name" => "Name Z to A"],
                4 => ["id" => 4, "name" => "Next appointment"],
            ];
        } else {
            $sort = [
                0 => ["id" => 0, "name" => "Niedrigere Kosten"],
                1 => ["id" => 1, "name" => "obere Kosten"],
                2 => ["id" => 2, "name" => "Nennen Sie A bis Z"],
                3 => ["id" => 3, "name" => "Nennen Sie Z bis A"],
                4 => ["id" => 4, "name" => "Nächster Termin"],
            ];
        }
        $page['sort'] = $sort;
        $page['specialists'] = MedSearch::collection($specialists);
        $daysList = DayNew::all();
        $page['days'] = DayResource::collection($daysList);

        return $this->sendResponse($page, __("langMessage.all_data"));
    }

}
