<?php

namespace App\Http\Controllers;
use App\Models\Clinic_gallery;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use File;
class SingleClinicGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $tab =$request->tab;
        return \Redirect::back()->withErrors(['tab' => $tab]);
        // return redirect()->back()->with(compact('tab'));
        // return redirect()->route('clinics.edit', $request->get('clinic_id'))->with('flash_success', 'Successfully Saved!');
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
        $gallery= Clinic_gallery::where('id',$id)->first();
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
        // $input['clinic_id'] =$request->get('clinic_id');
        Clinic_gallery::findOrFail($id)->update($input);
        $tab =$request->tab;
        return \Redirect::back()->withErrors(['tab' => $tab]);
        // return redirect()->route('clinics.edit', $gallery->clinic_id)->with('flash_success', 'Successfully Saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
            $tab ='kt_ecommerce_add_days_advanced_gallery';
            return \Redirect::back()->withErrors(['tab' => $tab])->with('flash_del', 'Successfully Delete!');
            // return redirect()->back()->with('flash_del', 'Successfully Delete!');

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
