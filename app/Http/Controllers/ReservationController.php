<?php

namespace App\Http\Controllers;

use App\Models\FCMNotification;
use App\Models\Reservation;
use App\Models\Reservation_status;
use App\Models\User;
use Database\Seeders\ReservationStatus;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    protected $object;
    protected $viewName;
    public function __construct(Reservation $object)
    {
        // $this->middleware('auth:admin');
        // $this->middleware('auth:doctor');
        $this->object = $object;
        $this->viewName = 'admin.reservation.';

    }
      //
    public function allReservation(){
        $status=Reservation_status::get();
        $rows=Reservation::orderBy("reservation_status_id", "asc")->orderBy("reservation_date", "asc")->get();


        return view($this->viewName.'all', compact('rows','status'));

    }
    /****
     * filter form
     */
    public function filter(Request $request)
    {
        \Log::info($request->all());

        $name= $request->get('name');
        //search func
        $opo=Reservation::select('*');

        if ($request->get("filter_date") && $request->get("filter_date") ==2) {

            $opo->orderBy("reservation_date", "desc");


            }else{

                $opo->orderBy("reservation_date", "asc");
            }


        if ($request->get("status_id") && !empty($request->get("status_id"))) {
            $opo->where('reservation_status_id', '=',$request->get("status_id") );

        }



        $rows =  $opo->get();
        return view($this->viewName . 'subAll', compact('rows'))->render();
    }

    public function showAllReservation($id){
        $row=Reservation::where("id", $id)->first();


        return view($this->viewName.'allView', compact('row'));
    }

    public function comReservation($id){
        $row=Reservation::where("id", $id)->first();
        $row->update(['reservation_status_id'=>2]);
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
            'user_id' => 1,
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

    public function delReservation($id){
        $row=Reservation::where("id", $id)->first();

        $row->update(['reservation_status_id'=>3]);
//send notification api for cancel reservation
        return redirect()->back();
    }

    public function completeReservation(){
        $rows=Reservation::where('reservation_status_id',2)->orderBy("reservation_date", "Desc")->get();


        return view($this->viewName.'complete', compact('rows'));
    }


    public function showCompleteReservation($id){
        $row=Reservation::where('reservation_status_id',2)->where("id", $id)->first();


        return view($this->viewName.'completeView', compact('row'));
    }
    public function cancelledReservation(){
        $rows=Reservation::where('reservation_status_id',3)->orderBy("reservation_date", "Desc")->get();


        return view($this->viewName.'cancelled', compact('rows'));
    }


    public function showCancelledReservation($id){
        $row=Reservation::where('reservation_status_id',3)->where("id", $id)->first();


        return view($this->viewName.'cancelledView', compact('row'));
    }

    public function updateReservation(Request $request){
        $row=Reservation::where("id", $request->reservId)->first();

        $row->update(['notes'=>$request->notes]);

        return redirect()->back();
    }
}
