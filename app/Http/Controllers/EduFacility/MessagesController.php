<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessagesController extends Controller
{
    protected $facility;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

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
    public function index(Request $request)
    {

        $query = $this->facility->messages()->orderBy('id','desc');

        if (isset($request->status) && $request->status != null && $request->status != 'all') {
            $query->where('status',$request->status);
            $_status = $request->status;
        }else{
            $_status = null;
        }

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        }else{
            $_to = null;
            $_from =  null;
        }

        $data = $query->paginate(10);
        return view('edu-facility.messages.index',compact('data','_status','_to','_from'));

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacilityPriceController  $adAdTypeController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Message::where('id',$id)->where('facility_id',$this->facility->id)->first();
        $data->status = 'read';
        $data->update();

        return view('edu-facility.messages.show',compact('data'));
    }
}
