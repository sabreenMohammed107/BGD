<?php

namespace App\Http\Controllers;

use App\Models\Clinic_review;
use App\Models\Doctor;
use App\Models\Doctors_pasition;
use App\Models\Medical_field;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorDataController extends Controller
{
    //
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
}
