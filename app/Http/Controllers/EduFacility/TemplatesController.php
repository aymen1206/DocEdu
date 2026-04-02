<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EduFacility;

class TemplatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('edu_facility.auth:edu_facility');
        $this->facility = auth()->guard('edu_facility')->user();
    }
    public function templateOne()
    {
        
        $schoolname=$this->facility->tenant->name;
        $users=EduFacility::tenanting()->get();
        return view('edu-facility.tempOne.form', compact('schoolname', 'users')); 
    }
    public function templateTwo()
    {   
        
        $schoolname=$this->facility->tenant->name;
        $users=EduFacility::tenanting()->get();
        return view('edu-facility.tempTwo.form', compact('schoolname', 'users')); 
    }
    public function templateThree()
    {
        $schoolname=$this->facility->tenant->name;
        $users=EduFacility::tenanting()->get();
        return view('edu-facility.tempThree.form', compact('schoolname', 'users')); 
    }
}