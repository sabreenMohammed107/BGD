<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
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
        $rows=Reservation::orderBy("reservation_date", "Desc")->get();


        return view($this->viewName.'all', compact('rows'));

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
