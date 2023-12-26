<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Day;
use App\Models\DayNew;
use App\Models\Doctor;
use App\Models\Doctor_clinic;
use App\Models\Doctor_schedule;
use App\Models\Insurance_type;
use App\Models\Reservation;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DoctorClinicController extends Controller
{

    protected $object;
    protected $viewName;
    protected $routeName ;

    protected $doctorId ;
    public function __construct(Doctor_clinic $object)
    {
        $this->middleware('auth:doctor');
        $this->middleware(function ($request, $next) {
            $this->doctorId = Auth::guard('doctor')->user()->id;


            return $next($request);
        });

        $this->object = $object;
        $this->viewName = 'doctor.clinics.';
    $this->routeName = 'doctor-clinics.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $rows=Doctor_clinic::where('doctor_id',$this->doctorId)->orderBy("created_at", "Desc")->get();


        return view($this->viewName.'index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $doctors = Doctor::all();
        $doctor= Doctor::where('id',$this->doctorId)->first();
        $cities = City::all();
        $status = Status::all();
        $insurances = Insurance_type::all();
        //
        return view($this->viewName.'add', compact('doctor','cities','status','insurances'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->except(['_token']);

        if ($request->has('parking_allowed')) {

            $input['parking_allowed'] = '1';
        } else {
            $input['parking_allowed'] = '0';
        }
        if ($request->has('home_visit_allowed')) {

            $input['home_visit_allowed'] = '1';
        } else {
            $input['home_visit_allowed'] = '0';
        }
        if ($request->has('disability_allowed')) {

            $input['disability_allowed'] = '1';
        } else {
            $input['disability_allowed'] = '0';
        }

//save tude
if ($request->get('map_tude')) {
    $tude=explode(',', $request->get('map_tude'));
      $input['latitude'] = $tude[0];
      $input['longitude'] = $tude[1];
  }
        Doctor_clinic::create($input);
        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Doctor_clinic::find($id);
        $doctor= Doctor::where('id', $this->doctorId)->first();
        $cities = City::all();
        $status = Status::all();
        $insurances = Insurance_type::all();
        $days = DayNew::all();
        $doctorDays = Doctor_schedule::where('clinic_id',$id)->get();
        //
        return view($this->viewName.'edit', compact('row','doctor','cities','status','insurances','days','doctorDays'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $row = Doctor_clinic::find($id);
        $input = $request->except(['_token']);

        if ($request->has('parking_allowed')) {

            $input['parking_allowed'] = '1';
        } else {
            $input['parking_allowed'] = '0';
        }
        if ($request->has('home_visit_allowed')) {

            $input['home_visit_allowed'] = '1';
        } else {
            $input['home_visit_allowed'] = '0';
        }
        if ($request->has('disability_allowed')) {

            $input['disability_allowed'] = '1';
        } else {
            $input['disability_allowed'] = '0';
        }
//save tude
if ($request->get('map_tude')) {
    $tude=explode(',', $request->get('map_tude'));
      $input['latitude'] = $tude[0];
      $input['longitude'] = $tude[1];
  }
        $row->update($input);
        //schadual

            //update days

            $daysList = $request->kt_docs_repeater_basic;
            $updatedDaysList = Doctor_schedule::where('clinic_id', $row->id)->get();

            if ($updatedDaysList) {
                foreach ($updatedDaysList as $index => $update) {

                    if ($daysList) {
                        foreach ($daysList as $index => $opt) {
                            if (($update->time_from != $daysList[$index]['time_from']) && ($update->days_id != $daysList[$index]['days_id']) && $update->time_to != $daysList[$index]['time_to']) {
                                $update->delete();

                            }
                        }
                    }

                }
            }

            if ($daysList) {
                foreach ($daysList as $index => $opt) {

                    $evDay = Doctor_schedule::firstOrNew([

                        'days_id' => $daysList[$index]['days_id'],
                        'time_from' => $daysList[$index]['time_from'],
                        'time_to' => $daysList[$index]['time_to'],
                        'clinic_id' => $row->id,

                    ]);


                    $evDay->days_id = $daysList[$index]['days_id'];
                    $evDay->time_from = $daysList[$index]['time_from'];
                    $evDay->time_to = $daysList[$index]['time_to'];
                    $evDay->clinic_id = $row->id;

                    $evDay->save();

                }
            }
            //end days

        DB::commit();
        //Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route($this->routeName . 'index')->with('flash_success', 'تم الحفظ بنجاح');

    } catch (\Throwable$e) {
        // throw $th;
        DB::rollback();
        dd($e->getMessage());
        // return redirect()->back()->withInput()->withErrors($e->getMessage());

    }

     }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Doctor_clinic::where('id', $id)->first();

        try {


            $row->delete();
            return redirect()->back()->with('flash_del', 'Successfully Delete!');

        } catch (QueryException $q) {
            // return redirect()->back()->withInput()->with('flash_danger', $q->getMessage());
            return redirect()->back()->withInput()->with('flash_danger', 'Can’t delete This Row
            Because it related with another table');
        }
    }


    function getReservationChartData(Request $request)
    {
        $currentDate = Carbon::now();
        $reservationCounts = [];
        $clinicIds = Doctor_clinic::where('doctor_id', $this->doctorId)->pluck('id')->toArray();

        for ($i = 4; $i >= 0; $i--) {
            $monthStart = $currentDate->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $currentDate->copy()->subMonths($i)->endOfMonth();
        
            $count = Reservation::whereBetween('reservation_date', [$monthStart, $monthEnd])
                ->whereIn('clinic_id', $clinicIds)
                ->distinct('patient_id')
                ->count('patient_id');

                
        
            // Store the count for the month in an array
            $reservationCounts[$monthStart->format('M')] = $count;
        }


        $currentDate = Carbon::now();
        $monthStart = $currentDate->startOfMonth();
        $monthEnd = $currentDate->endOfMonth();
        $currentYear = Carbon::now()->startOfYear();
        $yearEnd = Carbon::now()->endOfYear();

        $counts = Reservation::join('reservation_statuses', 'reservations.reservation_status_id', '=', 'reservation_statuses.id')
            ->whereBetween('reservation_date', [$currentYear, $yearEnd])
            ->whereIn('clinic_id', $clinicIds)
            ->selectRaw('reservation_statuses.en_status as status, count(*) as count')
            ->groupBy('reservation_statuses.en_status')
            ->pluck('count', 'status');

        $clinics_counts = Reservation::join('doctor_clinics', 'reservations.clinic_id', '=', 'doctor_clinics.id')
            ->whereBetween('reservation_date', [$currentYear, $yearEnd])
            ->whereIn('clinic_id', $clinicIds)
            ->selectRaw('doctor_clinics.name as name, count(*) as count')
            ->groupBy('doctor_clinics.name')
            ->pluck('count', 'name');

        
        
        return [$reservationCounts, $counts, $clinics_counts];
    }
}
