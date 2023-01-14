<?php

namespace App\Http\Controllers;

use App\Models\bdg_data;
use App\Models\Faq;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    protected $object;
    protected $viewName;
    protected $routeName ;
    public function __construct(Faq $object)
    {
        $this->middleware('auth:admin');

        $this->object = $object;
        $this->viewName = 'admin.faq.';
    $this->routeName = 'faq.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows=Faq::orderBy("created_at", "Desc")->get();


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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['_token']);
        if ($request->has('active')) {

            $input['active'] = '1';
        } else {
            $input['active'] = '0';
        }

        Faq::create($input);
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
        $input = $request->except(['_token']);
        if ($request->has('active')) {

            $input['active'] = '1';
        } else {
            $input['active'] = '0';
        }

        Faq::findOrFail($request->get('faq_id'))->update($input);
        return redirect()->route($this->routeName.'index')->with('flash_success', 'Successfully Saved!');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country=Faq::where('id',$id)->first();
        try {

            $country->delete();
            return redirect()->back()->with('flash_success', 'Successfully Delete!');

        } catch (QueryException $q) {
            // return redirect()->back()->withInput()->with('flash_danger', $q->getMessage());
            return redirect()->back()->withInput()->with('flash_danger', 'Can’t delete This Row
            Because it related with another table');
        }
    }

    public function createForm(Request $request){
        $data=bdg_data::orderBy('id', 'desc')->first();
        return view($this->viewName.'bdgData',compact('data'));
    }

    public function DataForm(Request $request){
        $input = $request->except(['_token','logo']);
        if ($request->hasFile('logo')) {
            $attach_image = $request->file('logo');

            $input['logo'] = $this->UplaodImage($attach_image);
        }
        $row = bdg_data::findOrFail($request->get('dataId'));
        if($row){
            $row->update($input);

        }
        // bdg_data::findOrFail($request->get('dataId'))->update($input);
        return redirect()->back()->with('flash_success', 'Successfully Saved!');
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
        $uploadPath = public_path('uploads/data');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }
}
