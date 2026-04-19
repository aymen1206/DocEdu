<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
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

    public function index(){
        $data = DB::table('notifications')->where('target','facility')->where('target_id',$this->facility->id)->orderBy('id','desc')->get();
        return view('edu-facility.notifications.index',compact('data'));
    }

    public function show($id){
        $data = DB::table('notifications')->where(['id'=>$id],['target'=>'facility'],['target_id'=>$this->facility->id])->first();
        DB::table('notifications')->where(['id'=>$id],['target'=>'facility'],['target_id'=>$this->facility->id])->update(['status'=>1]);
        return view('edu-facility.notifications.show',compact('data'));
    }
    
    
    public function allReaded(){
        $data = DB::table('notifications')->where('target','facility')->where('target_id',$this->facility->id)->orderBy('id','desc')->get();
        DB::table('notifications')->where(['target'=>'facility'],['target_id'=>$this->facility->id])->update(['status'=>1]);
        return view('edu-facility.notifications.index',compact('data'));
    }
}
