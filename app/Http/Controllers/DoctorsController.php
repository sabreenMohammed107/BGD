<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Doctors_pasition;
use App\Models\Medical_field;
use App\Models\Status;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use File;
class DoctorsController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName ;
    public function __construct(Doctor $object)
    {
        $this->middleware('auth:admin');

        $this->object = $object;
        $this->viewName = 'admin.doctors.';
    $this->routeName = 'doctors.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows=doctor::orderBy("created_at", "Desc")->get();


        return view($this->viewName.'index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $medicals = Medical_field::all();
        $positions = Doctors_pasition::all();
        $status = Status::all();
        //
        return view($this->viewName.'add', compact('medicals','positions','status'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:doctors'],
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
        $input = $request->except(['_token','img','password']);
        if ($request->hasFile('img')) {
            $attach_image = $request->file('img');

            $input['img'] = $this->UplaodImage($attach_image);
        }
        if ($request->has('verified')) {

            $input['verified'] = '1';
        } else {
            $input['verified'] = '0';
        }
        $input['password'] = Hash::make($request['password']);
        Doctor::create($input);
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
        $row = Doctor::find($id);
        $medicals = Medical_field::all();
        $positions = Doctors_pasition::all();
        $status = Status::all();
        //
        return view($this->viewName.'edit', compact('row','medicals','positions','status'));
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
            'email' => 'required|email|unique:doctors,email,'.$id,
            'name' => 'required',
            'password' =>'required_with:confirmed|nullable',
        ]);

        $row = Doctor::find($id);
        $input = $request->except(['_token','img','password']);
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
        $row = Doctor::where('id', $id)->first();
        // Delete File ..
        $file = $row->img;
        $file_name = public_path('uploads/doctors/' . $file);
        try {
            File::delete($file_name);

            $row->delete();
            return redirect()->back()->with('flash_del', 'Successfully Delete!');

        } catch (QueryException $q) {
            // return redirect()->back()->withInput()->with('flash_danger', $q->getMessage());
            return redirect()->back()->withInput()->with('flash_danger', 'Can’t delete This Row
            Because it related with another table');
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


    public function selectSubMideical(Request $request){

    }
}
