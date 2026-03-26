<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Tamaraconfig;
use App\Models\Tabbyconfig;
use App\Models\Jeelconfig;
use App\Models\Cities;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use App\Models\EduFacility;
use App\Models\FacilityAd;
use App\Models\Student;
use App\Models\Visites;
use App\Models\Message;
use App\Models\RecommendedCareHomes;
use App\Models\RecommendedFacilities;
use App\Models\Indexcomment;
use App\Models\NotCollectedOrders;
use Illuminate\Http\Request;
use Alert;
use App\Models\Gallery;
use DB;
use Mail;
use Mapper;
use App\Models\Finances;
use App\Services\SmsService;
use App\Models\Adminfinanciallog;
use App\Models\Financiallog;
class HomeController extends Controller
{
    public function home(){
           return view('site.home');
    }
    public function forgetPassword(){
        return view('site.password.forget-password');
    }
    public function login(){
        return view('site.login');
    }
    public function loginVerifiey(){
        return view('site.loginstudent');
    }
    public function verifyLoginStudent($phone,$ops){
        return view('site.verifyLoginStudent',compact('phone','ops'));
    }	
    public function verifyLoginFacility($phone){
        return view('site.verifyLoginFacility',compact('phone'));
    }		
    public function resendcode($phone){
            $st=Student::select('*')->where('phone',$phone)->first();
			//generate code
			$virifiedCode=$st->phone_verify;
			//--SMS send code
			$phoneFormat=SmsService::convertPhoneNumber($phone);
		    SmsService::SendMsgatSMS($phoneFormat, 'كود التحقق هو: ' . $virifiedCode);
        return redirect()->back()->with('toast_success',__('lang.code_sent_Successfully'));
    }
     public function rigisterStudent(){ 
        return view('site.rigisterStudent');
    }
   
}