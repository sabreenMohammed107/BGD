<?php

namespace App\Http\Controllers;

use App\Models\Clinic_review;
use App\Models\Doctor;
use App\Models\Doctors_pasition;
use App\Models\FCMNotification;
use App\Models\Medical_field;
use App\Models\Reservation;
use App\Models\Reservation_status;
use App\Models\Status;
use App\Models\User;
use App\Notifications\PatientReservationNotification;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    public function doctorProfile($id)
    {
        $row = Doctor::find($id);
        $medicals = Medical_field::all();
        $positions = Doctors_pasition::all();
        $status = Status::all();
        $doctormedicals = $row->medicines->all();
        //
        return view('doctor.doctor-profile', compact('row', 'medicals', 'positions', 'status', 'doctormedicals'));
    }

    public function updateDoctorProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:doctors,email,' . $request->get('id'),
            'name' => 'required',
            'password' => 'required_with:confirmed|nullable',
        ]);
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $row = Doctor::find($request->get('id'));
            $input = $request->except(['_token', 'img', 'password']);
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
        } catch (\Throwable $e) {
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

    public function review()
    {
        $docId = Auth::guard('doctor')->user()->id;
        $doctor = Doctor::where('id', $docId)->first();

        $rows = Clinic_review::join('doctor_clinics', 'clinic_reviews.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id', $docId)->select('clinic_reviews.*')->get();

        return view('doctor.review', compact('rows', 'doctor'));
    }

    public function allReservation()
    {
        $docId = Auth::guard('doctor')->user()->id;
        $status = Reservation_status::get();

        $rows = Reservation::with('status')
            ->join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')
            ->where('doctor_clinics.doctor_id', $docId)
            ->select('reservations.*')->orderBy("created_at", "Desc")->get();

        return view($this->viewName . 'all', compact('rows', 'status'));

    }
    /****
     * filter form
     */
    public function filter(Request $request)
    {
        \Log::info($request->all());
        $docId = Auth::guard('doctor')->user()->id;
        $status = Reservation_status::get();
        $name = $request->get('name');
        //search func
        $opo = Reservation::with('status')
            ->join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')
            ->where('doctor_clinics.doctor_id', $docId)
            ->select('reservations.*');

        if ($request->get("filter_date") && $request->get("filter_date") == 2) {

            $opo->orderBy("reservation_date", "desc");

        } else {

            $opo->orderBy("reservation_date", "asc");
        }

        if ($request->get("status_id") && !empty($request->get("status_id"))) {
            $opo->where('reservation_status_id', '=', $request->get("status_id"));

        }

        $rows = $opo->get();
        return view($this->viewName . 'subAll', compact('rows'))->render();
    }

    /****
     * filter form
     */
    public function cancelledFilter(Request $request)
    {
        \Log::info($request->all());

        $name = $request->get('name');
        //search func
        $opo = Reservation::select('*')->whereIn('reservation_status_id', [3, 4]);

        if ($request->get("filter_date") && $request->get("filter_date") == 2) {

            $opo->orderBy("reservation_date", "desc");

        } else {

            $opo->orderBy("reservation_date", "asc");
        }

        if ($request->get("status_id") && !empty($request->get("status_id"))) {
            $opo->where('reservation_status_id', '=', $request->get("status_id"));

        }

        $rows = $opo->get();
        return view($this->viewName . 'subCancelled', compact('rows'))->render();
    }

    public function showAllReservation($id)
    {
        $docId = Auth::guard('doctor')->user()->id;
        $row = Reservation::where("id", $id)->first();

        return view($this->viewName . 'allView', compact('row'));
    }

    public function comReservation($id)
    {
        $docId = Auth::guard('doctor')->user()->id;
        $row = Reservation::where("id", $id)->first();
        if ($row) {
            $row->reservation_status_id = 2;
            $row->save();
        }
        // $row->update(['reservation_status_id'=>2]);
        //send notification api for confirm reservation
        $data = [
            'title_dt' => 'Ihre Reservierung ist vollständig',
            'body_dt' => 'gute Besserung',
            'title_en' => 'your reservation is complete ',
            'body_en' => 'get well soon',
            'status' => 'not_seen',
        ];

        //save f_c_m notification table
        FCMNotification::create([
            'title_dt' => 'Ihre Reservierung ist vollständig',
            'body_dt' => 'gute Besserung',
            'title_en' => 'your reservation is complete ',
            'body_en' => 'get well soon',
            'status' => 'not_seen',
            'user_id' => $row->patient_id,
        ]);

        //fcm notify
        $tokens = User::where('id', $row->patient_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        try
        {
            //test sabreen

            $SERVER_API_KEY = 'AAAAJnomq2Q:APA91bG29GU_QCYVh23XsdQM645Bgc61hX1orWqhbTOdsROrP0yNUnND_r1EbnQtmz9Nt1QIB3ekVXRAUG-SqZf3OCxGFw2zn1WDsizxoOC9SSfC82YziE1SaQoGe4A4Luq_0kcK3po7';

            if (App::getLocale() == "en") {
                $data = [
                    "registration_ids" => $tokens,
                    "notification" => [
                        "title" => 'BDG App :',
                        // "body" => 'Your visit '.date_format(date_create($row->reservation_date), "d.m.Y").' with '.$row->clinic->doctor->name.' was done - Thank you',
                        "body" => 'Dein Besuch vom ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' bei ' . $row->clinic->doctor->name . ' ist abgeschlossen – Vielen Dank!',

                    ],
                ];
            } else {
                $data = [
                    "registration_ids" => $tokens,
                    "notification" => [
                        "title" => 'BDG App :',
                        "body" => 'Dein Besuch vom ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' bei ' . $row->clinic->doctor->name . ' ist abgeschlossen – Vielen Dank!',

                    ],
                ];
            }
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

        } catch (\Exception $e) {
            // DB::rollback();
            return redirect()->back()->with($e->getMessage());
        }

        //end test
        return redirect()->back();
    }

    public function confReservation($id)
    {
        $docId = Auth::guard('doctor')->user()->id;
        $row = Reservation::where("id", $id)->first();
        if ($row) {
            $row->reservation_status_id = 5;
            $row->save();
        }
        // $row->update(['reservation_status_id'=>2]);
        //send notification api for confirm reservation
        $data = [
            'title_dt' => 'BDG App : ',
            'body_dt' => 'Deine Buchung bei ' . $row->clinic->doctor->name . ' wurde für den ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' zwischen ' . date('H:i', strtotime($row->time_from)) . ' und ' . date('H:i', strtotime($row->time_to)) . ' Uhr bestätigt.',
            'title_en' => 'BDG App : ',
            'body_en' => 'Your booking with ' . $row->clinic->doctor->name . ' was confirmed on ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' between ' . date('H:i', strtotime($row->time_from)) . ' and ' . date('H:i', strtotime($row->time_to)) . '',
            'status' => 'not_seen',
        ];

        //save f_c_m notification table
        FCMNotification::create([
            'title_dt' => 'BDG App : ',
            'body_dt' => 'Deine Buchung bei ' . $row->clinic->doctor->name . ' wurde für den ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' zwischen ' . date('H:i', strtotime($row->time_from)) . ' und ' . date('H:i', strtotime($row->time_to)) . ' Uhr bestätigt.',
            'title_en' => 'BDG App : ',
            'body_en' => 'Your booking with ' . $row->clinic->doctor->name . ' was confirmed on ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' between ' . date('H:i', strtotime($row->time_from)) . ' and ' . date('H:i', strtotime($row->time_to)) . '',
            'status' => 'not_seen',
            'user_id' => $row->patient_id,
        ]);

        //fcm notify
        $tokens = User::where('id', $row->patient_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        try
        {
            //test sabreen

            $SERVER_API_KEY = 'AAAAJnomq2Q:APA91bG29GU_QCYVh23XsdQM645Bgc61hX1orWqhbTOdsROrP0yNUnND_r1EbnQtmz9Nt1QIB3ekVXRAUG-SqZf3OCxGFw2zn1WDsizxoOC9SSfC82YziE1SaQoGe4A4Luq_0kcK3po7';

            if (App::getLocale() == "en") {
                $data = [
                    "registration_ids" => $tokens,
                    "notification" => [
                        "title" => 'BDG App : ',
                        // "body" => 'Your booking with '.$row->clinic->doctor->name.' was confirmed on '.date_format(date_create($row->reservation_date), "d.m.Y").' between '.date('H:i', strtotime($row->time_from)).' and '.date('H:i', strtotime($row->time_to)).'',
                        "body" => 'Deine Buchung bei ' . $row->clinic->doctor->name . ' wurde für den ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' zwischen ' . date('H:i', strtotime($row->time_from)) . ' und ' . date('H:i', strtotime($row->time_to)) . ' Uhr bestätigt.',

                    ],
                ];
            } else {
                $data = [
                    "registration_ids" => $tokens,
                    "notification" => [
                        "title" => 'BDG App : ',
                        "body" => 'Deine Buchung bei ' . $row->clinic->doctor->name . ' wurde für den ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' zwischen ' . date('H:i', strtotime($row->time_from)) . ' und ' . date('H:i', strtotime($row->time_to)) . ' Uhr bestätigt.',

                    ],
                ];
            }
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

        } catch (\Exception $e) {
            // DB::rollback();
            return redirect()->back()->with($e->getMessage());
        }
        return redirect()->back();
    }
    public function delReservation($id)
    {
        $docId = Auth::guard('doctor')->user()->id;
        $row = Reservation::where("id", $id)->first();

        if ($row) {
            $row->reservation_status_id = 3;
            $row->save();
        }
        // $row->update(['reservation_status_id'=>3]);
        //send notification api for cancelled reservation
        $data = [
            'title_dt' => 'BDG App : ',
            'body_dt' => 'Deine Buchung vom ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' bei ' . $row->clinic->doctor->name . ' wurde am ' . date_format(date_create(now()), "d.m.Y"). ' von ' . $row->clinic->doctor->name . ' storniert.',
            'title_en' => 'BDG App : ',
            'body_en' => 'Your booking ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' with ' . $row->clinic->doctor->name . ' was cancelled by doctor at ' . date_format(date_create(now()), "d.m.Y") . '',
            'status' => 'not_seen',
        ];

//save f_c_m notification table
        FCMNotification::create([
            'title_dt' => 'BDG App : ',
            'body_dt' => 'Deine Buchung vom ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' bei ' . $row->clinic->doctor->name . ' wurde am ' . date_format(date_create(now()), "d.m.Y") . ' von ' . $row->clinic->doctor->name . ' storniert.',
            'title_en' => 'BDG App : ',
            'body_en' => 'Your booking ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' with ' . $row->clinic->doctor->name . ' was cancelled by doctor at ' . date_format(date_create(now()), "d.m.Y") . '',
            'status' => 'not_seen',
            'user_id' => $row->patient_id,
        ]);

//fcm notify
        $tokens = User::where('id', $row->patient_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        try
        {
//test sabreen

            $SERVER_API_KEY = 'AAAAJnomq2Q:APA91bG29GU_QCYVh23XsdQM645Bgc61hX1orWqhbTOdsROrP0yNUnND_r1EbnQtmz9Nt1QIB3ekVXRAUG-SqZf3OCxGFw2zn1WDsizxoOC9SSfC82YziE1SaQoGe4A4Luq_0kcK3po7';
            if (App::getLocale() == "en") {
                $data = [
                    "registration_ids" => $tokens,
                    "notification" => [

                        "title" => 'BDG App',
                        "body" => 'Deine Buchung vom ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' bei ' . $row->clinic->doctor->name . ' wurde am ' . date_format(date_create(now()), "d.m.Y") . ' von ' . $row->clinic->doctor->name . ' storniert.',

                        // "body" => 'Your booking '.date_format(date_create($row->reservation_date), "d.m.Y").' with '.$row->clinic->doctor->name.' was cancelled by doctor at '.date_format(date_create(now()), "d.m.Y").'',
                    ],
                ];
            } else {
                $data = [
                    "registration_ids" => $tokens,
                    "notification" => [
                        "title" => 'BDG App',
                        "body" => 'Deine Buchung vom ' . date_format(date_create($row->reservation_date), "d.m.Y") . ' bei ' . $row->clinic->doctor->name . ' wurde am ' . date_format(date_create(now()), "d.m.Y") . ' von ' . $row->clinic->doctor->name . ' storniert.',
                    ],
                ];
            }
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

        } catch (\Exception $e) {
// DB::rollback();
            return redirect()->back()->with($e->getMessage());
        }

        return redirect()->back();
    }

    public function completeReservation()
    {
        $docId = Auth::guard('doctor')->user()->id;
        $rows = Reservation::with('status')->join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id', $docId)->select('reservations.*')->where('reservation_status_id', 2)->orderBy("reservation_date", "Desc")->get();

        return view($this->viewName . 'complete', compact('rows'));
    }

    public function showCompleteReservation($id)
    {
        $docId = Auth::guard('doctor')->user()->id;
        $row = Reservation::where('reservation_status_id', 2)->where("id", $id)->first();

        return view($this->viewName . 'completeView', compact('row'));
    }
    public function cancelledReservation()
    {
        $status = Reservation_status::whereIn('id', [3, 4])->get();
        $docId = Auth::guard('doctor')->user()->id;
        $rows = Reservation::with('status')->join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')->where('doctor_clinics.doctor_id', $docId)->select('reservations.*')->whereIn('reservation_status_id', [3, 4])->orderBy("reservation_date", "Desc")->get();

        return view($this->viewName . 'cancelled', compact('rows', 'status'));
    }

    public function showCancelledReservation($id)
    {
        $docId = Auth::guard('doctor')->user()->id;
        $row = Reservation::where('reservation_status_id', 3)->where("id", $id)->first();

        return view($this->viewName . 'cancelledView', compact('row'));
    }

    public function updateReservation(Request $request)
    {
        $row = Reservation::where("id", $request->reservId)->first();

        $row->update(['notes' => $request->notes]);
        $offerData = [
            'name' => $row->patient->name ?? '',
            'body' => 'has set an appointment',
            'date' => $row->reservation_date,
            'time' => $row->time_from,

        ];

        $doc = Auth::guard('doctor')->user();
        $doc->notify(new PatientReservationNotification($offerData));
        return redirect()->back();
    }
}
