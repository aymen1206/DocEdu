<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EduFacility;
use App\Models\Interrsted_facilities;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class CustomAuthController extends Controller
{


	public function register(Request $request)
	{
			   
		$validator = Validator::make($request->all(), [			
			'edu_facility' => ['required', 'string', 'max:255'],	
			'responseble' => ['required', 'string', 'max:255'],
			'guardian_phone' => ['required', 'string',  'numeric', 'starts_with:966,5,05,1,01'],
			]);

		if ($validator->fails()) {				
		    $res= response()->json($validator->errors()->all());
			$resp = $res->getData(true);
			return view('site.rigisterStudent',compact('resp'));		
		}else{

		$int_facility = new Interrsted_facilities;
		$int_facility->facility_name = $request->edu_facility;
        $int_facility->responseble = $request->responseble;
        $int_facility->guardian_phone = $request->guardian_phone;
        $int_facility->save();
		$res= response()->json(['success']);
		$resp = $res->getData(true);
		return view('site.rigisterStudent',compact('resp'));
		 }

	}

}