<?php

namespace App\Http\Controllers;

use App\Models\Doctors_pasition;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DoctorsPositionController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName ;

    /**
     * UserController Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Doctors_pasition $object)
    {
        $this->middleware('auth:admin');

        $this->object = $object;
        $this->viewName = 'admin.positions.';
    $this->routeName = 'position.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows=Doctors_pasition::orderBy("created_at", "Desc")->get();


        return view($this->viewName.'index', compact('rows'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['_token']);



        Doctors_pasition::create($input);
        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctors_pasition  $specialzation
     * @return \Illuminate\Http\Response
     */
    public function show(Doctors_pasition $doctors_pasition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctors_pasition  $specialzation
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctors_pasition $doctors_pasition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *

     * @param  \App\Models\Doctors_pasition  $specialzation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctors_pasition $Doctors_pasition)
    {

        $input = $request->except(['_token','position_id']);


        Doctors_pasition::findOrFail($request->get('position_id'))->update($input);
        // $specialzation->update($input);

        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctors_pasition  $specialzation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $country=Doctors_pasition::where('id',$id)->first();
        try {

            $country->delete();
            return redirect()->back()->with('flash_success', 'Successfully Delete!');

        } catch (QueryException $q) {
            // return redirect()->back()->withInput()->with('flash_danger', $q->getMessage());
            return redirect()->back()->withInput()->with('flash_danger', 'Can’t delete This Row
            Because it related with another table');
        }
    }
}
