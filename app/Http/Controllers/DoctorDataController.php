<?php

namespace App\Http\Controllers;

use App\Models\Clinic_review;
use App\Models\Doctor;
use App\Models\Doctors_pasition;
use App\Models\Medical_field;
use App\Models\Reservation;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorDataController extends Controller
{
    //
    protected $object;
    protected $viewName;
    public function __construct(Reservation $object)
    {
        // $this->middleware('auth:admin');
        // $this->middleware('auth:doctor');
        $this->object = $object;
        $this->viewName = 'admin.reservation.';

    }
    public function doctorProfile($id){
        $row = Doctor::find($id);
        $medicals = Medical_field::all();
        $positions = Doctors_pasition::all();
        $status = Status::all();
        //
        return view('doctor.doctor-profile', compact('row','medicals','positions','status'));
    }


    public function updateDoctorProfile(Request $request){
        $request->validate([
            'email' => 'required|email|unique:doctors,email,'.$request->get('id'),
            'name' => 'required',
            'password' =>'required_with:confirmed|nullable',
        ]);

        $row = Doctor::find($request->get('id'));
        $input = $request->except(['_token','img','password']);
        if ($request->hasFile('img')) {
            $attach_image = $request->file('img');

            $input['img'] = $this->UplaodImage($attach_image);
        }
        if ($request->has('verified')) {

            $input['verified'] = '1';
        } else {
            $input['verified'] = '0';
        }
        if (!empty($request->get('password'))) {
            $input['password'] = Hash::make($request->get('password'));
        }
        // $input['password'] = Hash::make($request['password']);
        $row->update($input);
        return redirect()->back();
    }

    public function UplaodImage($file_request)
    {
        //  This is Image Info..
        $file = $file_request;
        $name = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $path = $file->getRealPath();
        $mime = $file->getMimeType();

        // Rename The Image ..
        $imageName = $name;
        $uploadPath = public_path('uploads/doctors');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }

    public function review(){
        $docId= Auth::guard('doctor')->user()->id;
        $doctor = Doctor::where('id',$docId)->first();
        $rows=Clinic_review::join('doctor_clinics', 'clinic_reviews.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id',$docId)->get();


        return view('doctor.review', compact('rows','doctor'));
    }


    public function allReservation(){
        $docId= Auth::guard('doctor')->user()->id;

        $rows= DB::table('reservations as res')->join('doctor_clinics', 'res.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id',$docId)->select('res.*')->orderBy("reservation_date", "Desc")->get();
        return($rows);

        // return view($this->viewName.'all', compact('rows'));

    }
    public function showAllReservation($id){
        $docId= Auth::guard('doctor')->user()->id;
        $row=Reservation::where("id", $id)->first();


        return view($this->viewName.'allView', compact('row'));
    }

    public function comReservation($id){
        $docId= Auth::guard('doctor')->user()->id;
        $row=Reservation::where("id", $id)->first();
        if($row){
$row->reservation_status_id=2;
$row->save();
        }
        // $row->update(['reservation_status_id'=>2]);

        return redirect()->back();
    }

    public function delReservation($id){
        $docId= Auth::guard('doctor')->user()->id;
        $row=Reservation::where("id", $id)->first();

        if($row){
            $row->reservation_status_id=3;
            $row->save();
                    }
                    // $row->update(['reservation_status_id'=>3]);

        return redirect()->back();
    }

    public function completeReservation(){
        $docId= Auth::guard('doctor')->user()->id;
        $rows=Reservation::join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id',$docId)->where('reservation_status_id',2)->orderBy("reservation_date", "Desc")->get();


        return view($this->viewName.'complete', compact('rows'));
    }


    public function showCompleteReservation($id){
        $docId= Auth::guard('doctor')->user()->id;
        $row=Reservation::where('reservation_status_id',2)->where("id", $id)->first();


        return view($this->viewName.'completeView', compact('row'));
    }
    public function cancelledReservation(){
        $docId= Auth::guard('doctor')->user()->id;
        $rows=Reservation::join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id',$docId)->where('reservation_status_id',3)->orderBy("reservation_date", "Desc")->get();


        return view($this->viewName.'cancelled', compact('rows'));
    }


    public function showCancelledReservation($id){
        $docId= Auth::guard('doctor')->user()->id;
        $row=Reservation::where('reservation_status_id',3)->where("id", $id)->first();


        return view($this->viewName.'cancelledView', compact('row'));
    }

    public function updateReservation(Request $request){
        $row=Reservation::where("id", $request->reservId)->first();

        $row->update(['notes'=>$request->notes]);

        return redirect()->back();
    }
}
