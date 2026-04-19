<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('edu_facility.auth:edu_facility');
        $this->facility = auth()->guard('edu_facility')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        $data = Gallery::where('facility_id',$this->facility->id)->get();
        return view('edu-facility.gallery.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('edu-facility.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function galleryUpload(Request $request)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gallery = new Gallery;

        if ($request->has('image') == true) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path("uploads/gallery/{$imageName}");
            $image->move(public_path('uploads/gallery/'), $imageName);
            $source = \Tinify\fromFile($path);
            $source->toFile($path);
            $gallery->facility_id = $this->facility->id;
            $gallery->image = 'uploads/gallery/'.$imageName;
            $gallery->save();
        }
        return redirect()->back()->with('toast_success',  trans('lang.save_success'));

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
        $gallery = Gallery::where('id',$id)->where('facility_id',$this->facility->id)->first();
        if ($gallery != null){
            if (is_file(asset('uploads/gallery/'.$gallery->image))){
                unlink(asset('uploads/gallery/'.$gallery->image));
            }
            $gallery->delete();
        }

        return redirect()->back()->with('toast_success',  trans('lang.delete_success'));
    }
}
