<?php

namespace App\Http\Controllers;

use App\Models\Clinic_gallery;
use App\Models\Doctor_clinic;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class ClinicGalleryController extends Controller
{

    protected $object;
    protected $viewName;
    protected $routeName;

    /**
     * UserController Constructor.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Clinic_gallery $object)
    {
        $this->middleware('auth');

        $this->object = $object;
        $this->viewName = 'admin.clinic-gallery.';
        $this->routeName = 'admin-clinic-gallery.';
    }/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Clinic_gallery::whereNotNull('clinic_id')->orderBy("created_at", "Desc")->get();
        $clinics = Doctor_clinic::get();

        return view($this->viewName . 'index', compact(['rows', 'clinics']));
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

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
              $input=[];
                $name = $file->getClientOriginalName();


                // Rename The Image ..
                $imageName = $name;
                $uploadPath = public_path('uploads/galleries');

                // Move The image..
                $file->move($uploadPath, $imageName);
                //save in DB
                if ($request->has('active')) {

                    $input['active'] = '1';
                } else {
                    $input['active'] = '0';
                }
                $input['image'] = $imageName;
                $input['clinic_id'] =$request->get('clinic_id');
                Clinic_gallery::create($input);
            }
        }
        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');    }


    /**
     * Display the specified resource.
     *

     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *

     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except(['_token','gallery_id','img']);
        if ($request->hasFile('img')) {
            $attach_image = $request->file('img');

            $input['image'] = $this->UplaodImage($attach_image);
        }
        if ($request->has('active')) {

            $input['active'] = '1';
        } else {
            $input['active'] = '0';
        }
        $input['clinic_id'] =$request->get('clinic_id');
        Clinic_gallery::findOrFail($id)->update($input);
        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');    }


    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Clinic_gallery::where('id', $id)->first();
         // Delete File ..
         $file = $gallery->image;
         $file_name = public_path('uploads/galleries/' . $file);
         try {
             File::delete($file_name);

            $gallery->delete();
            return redirect()->back()->with('flash_del', 'Successfully Delete!');

        } catch (QueryException $q) {
            // return redirect()->back()->withInput()->with('flash_danger', $q->getMessage());
            return redirect()->back()->withInput()->with('flash_danger', 'Can’t delete This Row
            Because it related with another table');
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
          $imageName = $name;
          $uploadPath = public_path('uploads/galleries');

          // Move The image..
          $file->move($uploadPath, $imageName);

          return $imageName;
      }
}
