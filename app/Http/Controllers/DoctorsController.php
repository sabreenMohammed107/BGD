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
use Illuminate\Support\Facades\DB;
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

        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $validator = Validator::make(request()->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:doctors'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'mobile'=> ['required','digits:14'],
            'mobile'=> ['required','string','min:10','max:14','regex:/^([0-9\s\-\+\(\)]*)$/'],

           ]);
        if($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput()->withErrors($errors);
        }
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

        $doctor=Doctor::create($input);
        if (!empty($request->get('medicines'))) {

            $doctor->medicines()->attach($request->medicines);

        }
        DB::commit();
        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route($this->routeName . 'index')->with('flash_success', 'Successfully Save  ');

    } catch (\Throwable $e) {
        // throw $th;
        DB::rollback();
        return redirect()->back()->withInput()->withErrors($e->getMessage());

    }  }

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
        $doctormedicals = $row->medicines->all();
        return view($this->viewName.'edit', compact('row','medicals','positions','status','doctormedicals'));
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

        $validator = Validator::make(request()->all(),[
            'email' => 'required|email|unique:doctors,email,'.$id,
            'name' => 'required',
            'password' =>'required_with:confirmed|nullable',
            'mobile'=> ['required','string','min:10','max:14','regex:/^([0-9\s\-\+\(\)]*)$/'],
           ]);
        if($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }
        DB::beginTransaction();
        try {
            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
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
        if ($request->medicines) {
            $row->medicines()->sync($request->medicines);
        }
        DB::commit();
        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route($this->routeName . 'index')->with('flash_success', 'Successfully Save');

    } catch (\Throwable$e) {
        // throw $th;
        DB::rollback();
        return redirect()->back()->withInput()->withErrors($e->getMessage());

    }
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
 $row->medicines()->detach();
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
