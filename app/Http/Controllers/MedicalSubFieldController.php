<?php

namespace App\Http\Controllers;

use App\Models\Medical_field;
use App\Models\Medical_sub_field;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use File;
class MedicalSubFieldController extends Controller
{
    protected $object;
    protected $viewName;
    protected $routeName ;

    /**
     * UserController Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Medical_sub_field $object)
    {
        $this->middleware('auth:admin');

        $this->object = $object;
        $this->viewName = 'admin.medicine-sub-fields.';
    $this->routeName = 'medicine-sub-fields.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows=Medical_sub_field::orderBy("created_at", "Desc")->get();
        $fields=Medical_field::orderBy("created_at", "Desc")->get();

        return view($this->viewName.'index', compact(['rows','fields']));
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
        $input = $request->except(['_token','field_img']);
        if ($request->hasFile('field_img')) {
            $attach_image = $request->file('field_img');

            $input['field_img'] = $this->UplaodImage($attach_image);
        }



        Medical_sub_field::create($input);
    return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medical_sub_field  $medical_sub_field
     * @return \Illuminate\Http\Response
     */
    public function show(Medical_sub_field $medical_sub_field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medical_sub_field  $medical_sub_field
     * @return \Illuminate\Http\Response
     */
    public function edit(Medical_sub_field $medical_sub_field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medical_sub_field  $medical_sub_field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except(['_token','field_img']);
        if ($request->hasFile('field_img')) {
            $attach_image = $request->file('field_img');

            $input['field_img'] = $this->UplaodImage($attach_image);
        }

        Medical_sub_field::findOrFail($id)->update($input);

    return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medical_sub_field  $medical_sub_field
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medical_sub_field=Medical_sub_field::where('id',$id)->first();
        // Delete File ..
        $file = $medical_sub_field->field_img;
        $file_name = public_path('uploads/medical_sub_fields/' . $file);
        try {
            File::delete($file_name);
            $medical_sub_field->delete();
            return redirect()->back()->with('flash_success', 'Successfully Delete!');

        } catch (QueryException $q) {
            return redirect()->back()->withInput()->with('flash_danger', $q->getMessage());

        }
    }


    /* uplaud image
       */
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
    //   $imageName = $name;
        $imageName = preg_replace('/[^A-Za-z0-9]/', '', $name);

        $uploadPath = public_path('uploads/medical_sub_fields');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
      }
}
