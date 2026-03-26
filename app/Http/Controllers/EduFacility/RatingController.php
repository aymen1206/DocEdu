<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use App\Models\EduFacility;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
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
        $averageRate = $this->facility->averageRate();

        // get total comments count -- it calculates approved comments count.
        $totalCommentsCount = $this->facility->totalCommentsCount();

        $query = $this->facility->comments()
                    ->join('students','comments.commented_id','=','students.id')
                    ->select('comments.*','students.name','students.email','students.id as student_id');

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $query->whereBetween('comments.created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        }else{
            $_to = null;
            $_from =  null;
        }

        $data = $query->where('comments.admin_approved',1)->get();
        return view('edu-facility.ratings.index',compact('data','_to','_from'));

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacilityPriceController  $adAdTypeController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data =  $this->facility->ratings;
        $data->status = 'read';
        $data->update();
        return view('edu-facility.ratings.show',compact('data'));
    }

    public function activeInactive($id)
    {
        $facility_id =  $this->facility->id;

        $data = DB::table('comments')->where('id',$id)->where('commentable_id',$facility_id)->first();

        if($data != null){

            if($data->approved == 0){
                 DB::table('comments')->where('id',$id)->where('commentable_id',$facility_id)->update(['approved' => 1]);
            }else{
                DB::table('comments')->where('id',$id)->where('commentable_id',$facility_id)->update(['approved' => 0]);
            }
        }

        return redirect()->back();
    }

    public function rate(Request $request)
    {
        $student = Student::find($request->student);
        $rating = $request->rating;
        $comment = $request->comment;
        $student->comment($this->facility, $comment, $rating);
        DB::table('edu_facilities')->where('id',$this->facility->id)->update(['rate'=>$this->facility->averageRate()]);
        return redirect()->back()->with('toast_success','تم ارسال التقييم بنجاح');;
    }
}
