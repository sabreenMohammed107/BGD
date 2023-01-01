<?php

namespace App\Http\Controllers;

use App\Models\Clinic_review;
use App\Models\Favourite_doctor;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName ;
    public function __construct(User $object)
    {
        $this->middleware('auth:admin');

        $this->object = $object;
        $this->viewName = 'admin.patients.';
    $this->routeName = 'patients.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows=User::orderBy("created_at", "Desc")->get();


        return view($this->viewName.'index', compact('rows'));
    }

public function favorite(){
    $rows=Favourite_doctor::orderBy("created_at", "Desc")->get();


    return view($this->viewName.'favourite', compact('rows'));
}

public function review(){
    $rows=Clinic_review::orderBy("created_at", "Desc")->get();


    return view($this->viewName.'review', compact('rows'));
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
