<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Order;
use App\Models\Student;
use App\Models\EduFacility;
use App\Models\InvoicesOrders;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class HomeController extends Controller
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
     * Show the EduFacility dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $schoolname=$this->facility->tenant->name;
        return view('edu-facility.home', compact('schoolname'));
    }

    public function users() {
        $schoolname='Admin';        
        $users=[];
        if(request()->getHost() == config('services.Central_HOST')) {
            $users = EduFacility::all();
        } else{        
            $schoolname=$this->facility->tenant->name;
            $users=EduFacility::tenanting()->get();
        }
        return view('edu-facility.users', compact('schoolname', 'users'));
    }

    public function parentCallNotice() {
        
       // $schoolname=$this->facility->tenant->name;
        //$users=EduFacility::tenanting()->get();
        
        $schoolname=$this->facility->tenant->name;
        return view('edu-facility.letter.form', compact('schoolname'));
    }

    public function absenceNotification() {
        
        $schoolname=$this->facility->tenant->name;
        $users=EduFacility::tenanting()->get();
        return view('edu-facility.abs.form', compact('schoolname', 'users'));
    }
    
     public function appreciation() {
        
        $schoolname=$this->facility->tenant->name;
        $users=EduFacility::tenanting()->get();
        return view('edu-facility.appreciation.prototypes', compact('schoolname', 'users'));
    }


}
