<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
class CountryController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName ;

    /**
     * UserController Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Country $object)
    {
        $this->middleware('auth');

        $this->object = $object;
        $this->viewName = 'admin.countries.';
    $this->routeName = 'countries.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows=Country::orderBy("created_at", "Desc")->get();


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
     * @param  \App\Http\Requests\StoreSpecialzationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['_token']);



        Country::create($input);
        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Specialzation  $specialzation
     * @return \Illuminate\Http\Response
     */
    public function show(Country $specialzation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specialzation  $specialzation
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $specialzation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSpecialzationRequest  $request
     * @param  \App\Models\Specialzation  $specialzation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {

        $input = $request->except(['_token','country_id']);


        country::findOrFail($request->get('country_id'))->update($input);
        // $specialzation->update($input);

        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialzation  $specialzation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $country=Country::where('id',$id)->first();
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
