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
        $status=Reservation_status::whereIn('id',[3,4])->get();
        $rows=Reservation::whereIn('reservation_status_id',[3,4])->orderBy("reservation_date", "Desc")->get();


        return view($this->viewName.'cancelled', compact('rows','status'));
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


      /****
     * filter form
     */
    public function cancelledFilter(Request $request)
    {
        \Log::info($request->all());

        $name= $request->get('name');
        //search func
        $opo=Reservation::select('*')->whereIn('reservation_status_id',[3,4]);

        if ($request->get("filter_date") && $request->get("filter_date") ==2) {

            $opo->orderBy("reservation_date", "desc");


            }else{

                $opo->orderBy("reservation_date", "asc");
            }


        if ($request->get("status_id") && !empty($request->get("status_id"))) {
            $opo->where('reservation_status_id', '=',$request->get("status_id") );

        }



        $rows =  $opo->get();
        return view($this->viewName . 'subCancelled', compact('rows'))->render();
    }
}
