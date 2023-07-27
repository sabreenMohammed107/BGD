<?php

namespace App\Http\Controllers;

use App\Models\Clinic_review;
use App\Models\Doctor;
use App\Models\Doctors_pasition;
use App\Models\FCMNotification;
use App\Models\Medical_field;
use App\Models\Reservation;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Database\QueryException;
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
        $doctormedicals = $row->medicines->all();
        //
        return view('doctor.doctor-profile', compact('row','medicals','positions','status','doctormedicals'));
    }


    public function updateDoctorProfile(Request $request){
        $request->validate([
            'email' => 'required|email|unique:doctors,email,'.$request->get('id'),
            'name' => 'required',
            'password' =>'required_with:confirmed|nullable',
        ]);
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
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
        if ($request->medicines) {
            $row->medicines()->sync($request->medicines);
        }
        DB::commit();
        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->back();
    } catch (\Throwable$e) {
        // throw $th;
        DB::rollback();
        return redirect()->back()->withInput()->withErrors($e->getMessage());

    }

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

        $rows=Clinic_review::join('doctor_clinics', 'clinic_reviews.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id',$docId)->select('clinic_reviews.*')->get();


        return view('doctor.review', compact('rows','doctor'));
    }


    public function allReservation(){
        $docId= Auth::guard('doctor')->user()->id;

        $rows= Reservation::with('status')->join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id',$docId)->select('reservations.*')->orderBy("reservation_date", "Desc")->get();

        return view($this->viewName.'all', compact('rows'));

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
  //send notification api for confirm reservation
  $data = [
    'title_dt' => 'تم إضافه دفعة ماليه جديده',
    'body_dt' => '$details->net_salary' ,
    'title_en' => 'A new payment has been added',
    'body_en' =>'$details->net_salary' ,
    'status' => 'not_seen',
];





//save f_c_m notification table
FCMNotification::create([
    'title_ar' => 'تم إضافه دفعة ماليه جديده',
    'body_ar' => '$details->net_salary',
    'title_en' => 'A new payment has been added',
    'body_en' => '$details->net_salary',
    'status' => 'not_seen',
    'user_id' => 25,
]);


//fcm notify
$tokens = User::whereNotNull('fcm_token')->where('register_approved', 1)->pluck('fcm_token')->toArray();
try
{
//test sabreen

$SERVER_API_KEY = 'AAAAJnomq2Q:APA91bG29GU_QCYVh23XsdQM645Bgc61hX1orWqhbTOdsROrP0yNUnND_r1EbnQtmz9Nt1QIB3ekVXRAUG-SqZf3OCxGFw2zn1WDsizxoOC9SSfC82YziE1SaQoGe4A4Luq_0kcK3po7';

$data = [
   "registration_ids" => $tokens,
   "notification" => [
       "title" => 'مرحبا',
       "body" => 'تم اضافة دفعة ماليه جديده ',
   ]
];
$dataString = json_encode($data);

$headers = [
   'Authorization: key=' . $SERVER_API_KEY,
   'Content-Type: application/json',
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

$response = curl_exec($ch);

//    dd($response);

} catch (\Exception$e) {
// DB::rollback();
return redirect()->back()->with($e->getMessage());
}


 //end test
        return redirect()->back();
    }

    public function confReservation($id){
        $docId= Auth::guard('doctor')->user()->id;
        $row=Reservation::where("id", $id)->first();
        if($row){
$row->reservation_status_id=5;
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
        $rows=Reservation::with('status')->join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id',$docId)->select('reservations.*')->where('reservation_status_id',2)->orderBy("reservation_date", "Desc")->get();


        return view($this->viewName.'complete', compact('rows'));
    }


    public function showCompleteReservation($id){
        $docId= Auth::guard('doctor')->user()->id;
        $row=Reservation::where('reservation_status_id',2)->where("id", $id)->first();


        return view($this->viewName.'completeView', compact('row'));
    }
    public function cancelledReservation(){
        $docId= Auth::guard('doctor')->user()->id;
        $rows=Reservation::with('status')->join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id',$docId)->select('reservations.*')->where('reservation_status_id',3)->orderBy("reservation_date", "Desc")->get();


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
