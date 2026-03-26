<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\EduFacility;
use App\Models\Student;
use App\Models\FacilietesRates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */ 
    public function __construct()
    {
        $this->middleware('student.auth');
        $this->middleware('StudentPhoneVerified');
    }

    /**
     * Show the Student dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = Auth::guard('student')->user();
        return view('student.home', compact('user'));
    }


     public function skipRate($facility_ID)
    {
        $_student = auth()->guard('student')->user();
         $student = Student::find($_student->id);
        DB::table('orders')->where('facility_id',$facility_ID)
        ->where('student',$student->id)
        ->update(['rate'=>'is_skipped']);
        return redirect()->back()->with('toast_success','تم تخطي التقيم بنجاح');;
    }

     public function rate(Request $request)
    {   $rating = 0;
        $_student = auth()->guard('student')->user();
         $student = Student::find($_student->id);
         if( $request->rating!=null){
        $rating = $request->rating;
         }
         else{            
        $rating = 1;
         }

        $comment = $request->comment;
        $_facility = EduFacility::find($request->facility);
        $student->comment($_facility, $comment, $rating);
        DB::table('edu_facilities')->where('id',$request->facility)->update(['rate'=>$_facility->averageRate()]);
        DB::table('orders')->where('facility_id',$request->facility)
        ->where('student',$student->id)
        ->update(['rate'=>'is_rated']);
        return redirect()->back()->with('toast_success','تم ارسال التقييم بنجاح');;
    }

    public function facilityRate(Request $request)
    {   
        $rating = 0;
        $_student = auth()->guard('student')->user();
        $student = Student::find($_student->id);
        $Rate = new FacilietesRates;
        
        $Rate->FacilityID= $request->FacilityID;
        $Rate->academic_level = $request->academic_level;
        $Rate->communication = $request->communication;
        $Rate->facilities = $request->facilities;
        $Rate->safety = $request->safety;
        $Rate->activities = $request->activities;
        $Rate->Commint = $request->comment;
        
        $Rate->save();

        return redirect()->back()->with('toast_success','تم ارسال التقييم بنجاح');;
    }

    public function changePassword() {
        return view('student.reset-password');
    }

    public function changePasswordPost(Request $request){
        request()->validate([
            'old_password' => 'required|min:8|string',
            'password' => 'required|min:8|confirmed|string',
        ]);
        $student = auth()->guard('student')->user();
        if (Hash::check($request->old_password, $student->password )) {
            $student->password = bcrypt($request->password);
            $student->update();
            return redirect()->back()->with('toast_success',  trans('lang.update_success'));
        }else{
            return redirect()->back()->with('toast_warning','كلمة المرور القديمة غير مطابقة');
        }
    }
    
    public function Consatlations(){
    $student=Auth::guard('student')->user()->id;
	return view('site.Consatlations',compact('student'));
    }

    public function RentConsaltation($st_id){
dd("here");
 
         }
}