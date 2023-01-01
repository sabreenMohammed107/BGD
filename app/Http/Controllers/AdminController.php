<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName ;
    public function __construct(Admin $object)
    {
        $this->middleware('auth:admin');

        $this->object = $object;
        $this->viewName = 'admin.all-admins.';
    $this->routeName = 'all-admins.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows=Admin::orderBy("created_at", "Desc")->get();


        return view($this->viewName.'index', compact('rows'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->viewName.'add');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validator($request->all())->validate();
        $input = $request->except(['_token','password']);

        if ($request->has('is_super')) {

            $input['is_super'] = 0;
        } else {
            $input['is_super'] = 1;
        }
        $input['password'] = Hash::make($request['password']);
        Admin::create($input);
        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');    }


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
        $row = Admin::find($id);

        return view($this->viewName.'edit', compact('row'));
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
        $request->validate([
            'email' => 'required|email|unique:admins,email,'.$id,
            'name' => 'required',
            'password' =>'required_with:confirmed|nullable',
        ]);

        $row = Admin::find($id);
        $input = $request->except(['_token','password']);

        if ($request->has('is_super')) {

            $input['is_super'] = 0;
        } else {
            $input['is_super'] = 1;
        }
        if (!empty($request->get('password'))) {
            $input['password'] = Hash::make($request->get('password'));
        }
        // $input['password'] = Hash::make($request['password']);
        $row->update($input);
        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');

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
        $row=Admin::where('id',$id)->first();
        try {

            $row->delete();
            return redirect()->back()->with('flash_success', 'Successfully Delete!');

        } catch (QueryException $q) {
            // return redirect()->back()->withInput()->with('flash_danger', $q->getMessage());
            return redirect()->back()->withInput()->with('flash_danger', 'Can’t delete This Row
            Because it related with another table');
        }

    }
}
