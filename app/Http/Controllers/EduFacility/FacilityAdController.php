<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use App\Models\FacilityAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityAdController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('edu_facility.auth:edu_facility');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FacilityAd::where('facility_id',auth()->guard('edu_facility')->user()->id)->get();
        return view('edu-facility.ads.index',compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stages = DB::table('edu_stages')
                    ->join('facilities_stages','facilities_stages.stage_id','=','edu_stages.id')
                    ->where('facilities_stages.facility_id',auth()->guard('edu_facility')->user()->id)
                    ->select('edu_stages.*')
                    ->get();
        $center_types =DB::table('facilities_center_types')
            ->join('center_types','facilities_center_types.center_type_id','=','center_types.id')
            ->select('center_types.*')
            ->where('facility_id',auth()->guard('edu_facility')->user()->id)
            ->get();

        $teacher_types =DB::table('facilities_types')
            ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
            ->select('edu_facilities_types.*')
            ->where('facility_id',auth()->guard('edu_facility')->user()->id)
            ->get();

        return view('edu-facility.ads.create',compact('stages','center_types','teacher_types'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|min:2|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => 'required|min:10',
            'stage' => 'nullable',
            'center_type' => 'nullable',
            'facility_type' => 'nullable',
            'price' => 'required',
            'price_after_discount' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'subscribers_allowed_number' => 'required',
        ]);

        $ad = new FacilityAd;
        $ad->facility_id = auth()->guard('edu_facility')->user()->id;
        $ad->title = $request->title;
        $ad->text = $request->text;

        $ad->stage = $request->stage;
        $ad->center_type = $request->center_type;
        $ad->facility_type = $request->facility_type;

        $ad->price = $request->price;
        $ad->price_after_discount = $request->price_after_discount;
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->subscribers_allowed_number = $request->subscribers_allowed_number;

        if ($request->has('image') == true) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path("uploads/ads/{$imageName}");
            $image->move(public_path('uploads/ads/'), $imageName);
            $source = \Tinify\fromFile($path);
            $source->toFile($path);
            $ad->image = 'uploads/ads/'.$imageName;
        } 
        $ad->save();

        return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacilityAdController  $adAdTypeController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = FacilityAd::where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->first();
        return view('edu-facility.ads.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $center_types =DB::table('facilities_center_types')
            ->join('center_types','facilities_center_types.center_type_id','=','center_types.id')
            ->select('center_types.*')
            ->where('facility_id',auth()->guard('edu_facility')->user()->id)
            ->get();

        $data = FacilityAd::where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->first();
        $stages = DB::table('edu_stages')
            ->join('facilities_stages','facilities_stages.stage_id','=','edu_stages.id')
            ->where('facilities_stages.facility_id',auth()->guard('edu_facility')->user()->id)
            ->select('edu_stages.*')
            ->get();

        $teacher_types =DB::table('facilities_types')
            ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
            ->select('edu_facilities_types.*')
            ->where('facility_id',auth()->guard('edu_facility')->user()->id)
            ->get();

        return view('edu-facility.ads.edit',compact('data','stages','center_types','teacher_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        request()->validate([
            'title' => 'required|min:2|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => 'required|min:10',
            'stage' => 'nullable',
            'center_type' => 'nullable',
            'price' => 'required',
            'price_after_discount' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'subscribers_allowed_number' => 'required',
        ]);

        $ad = FacilityAd::find($id);
        $ad->title = $request->title;
        $ad->text = $request->text;
        $ad->stage = $request->stage;
        $ad->center_type = $request->center_type;
        $ad->facility_type = $request->facility_type;
        $ad->price = $request->price;
        $ad->price_after_discount = $request->price_after_discount;
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->subscribers_allowed_number = $request->subscribers_allowed_number;

        if ($request->has('image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/ads/'), $imageName);
            $ad->image = 'uploads/ads/'.$imageName;
        }
        $ad->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacilityAdController  $adAdTypeController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adAd = FacilityAd::where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->first();
        $adAd->delete();
        return redirect('edu-facility/ads')->with('toast_success',  trans('lang.delete_success'));
    }
}
