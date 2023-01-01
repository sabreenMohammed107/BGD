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
        $this->middleware('auth:admin');

        $this->object = $object;
        $this->viewName = 'admin.reservation.';

    }
      //
    public function allReservation(){
        $rows=Reservation::orderBy("created_at", "Desc")->get();


        return view($this->viewName.'all', compact('rows'));

    }
    public function showAllReservation($id){
        $row=Reservation::where("id", $id)->first();


        return view($this->viewName.'allView', compact('row'));
    }

    public function completeReservation(){
        $rows=Reservation::where('reservation_status_id',2)->orderBy("created_at", "Desc")->get();


        return view($this->viewName.'complete', compact('rows'));
    }


    public function showCompleteReservation($id){
        $row=Reservation::where('reservation_status_id',2)->where("id", $id)->first();


        return view($this->viewName.'completeView', compact('row'));
    }
    public function cancelledReservation(){
        $rows=Reservation::where('reservation_status_id',3)->orderBy("created_at", "Desc")->get();


        return view($this->viewName.'cancelled', compact('rows'));
    }


    public function showCancelledReservation($id){
        $row=Reservation::where('reservation_status_id',3)->where("id", $id)->first();


        return view($this->viewName.'cancelledView', compact('row'));
    }
}
