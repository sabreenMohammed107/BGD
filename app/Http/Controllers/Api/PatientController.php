<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\FavouriteResource;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReviewResource;
use App\Models\Clinic_review;
use App\Models\Favourite_doctor;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Validator;

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
            return $this->convertErrorsToString($validator->messages());
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
            return $this->convertErrorsToString($validator->messages());
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

    public function showRreservation()
    {
        $userid = auth('api')->user()->id;
        $rows = Reservation::with('status')->where('patient_id', $userid)->orderBy("reservation_date", "Desc")->get();
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
                $reserve->reservation_status_id=2;
                $reserve->save();
                return $this->sendResponse(ReservationResource::make($reserve), 'U  reservation Cancelles successfully.');

                        }else{
                            return $this->sendError(null, 'Error happens!!');
                        }

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), 'Error happens!!');
        }

    }
}
