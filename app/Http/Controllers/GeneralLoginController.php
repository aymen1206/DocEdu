<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Children;
use App\Models\Tenant;
use App\Models\EduFacility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GeneralLoginController extends Controller
{
	

	public function loginVerifiey(Request $request)
	{
		request()->validate([
			'tenant_id' => ['required', 'string', 'max:255'],
			'password' => ['required', 'string', 'min:8'],			
		]);
		
		$tenant_id = $request->tenant_id;
		$password = $request->password;		
		$remember = $request->remember;
		
	//	if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], $remember)) {
	//		return redirect()->intended('/admin');
	//	}
		 
		if (Auth::guard('edu_facility')->attempt(['tenant_id' => $tenant_id, 'password' => $password], $remember)) {
			return redirect()->intended('edu-facility');
		}
		 	 			
		return redirect()->back()->with('toast_error',  trans('auth.failed'));
	}


	public function registerTenant(Request $request)
	{   
	$emails = ""; $domain =null;
		$defaultDomains = ['example.com','testmail.com','mailinator.com','fakemail.com','dummy.com'];
		$username = strtolower(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 8));
		$emailDomain = $domain ?? $defaultDomains[array_rand($defaultDomains)];
		$fakeEmail = $username . '@' . $emailDomain;
	
		 
		$validator = Validator::make($request->all(), [
			'scname' => ['sometimes','required', 'string', 'max:255'],
			'usname' => ['required', 'string', 'max:255'],
			'tenant' => ['sometimes','required', 'string', 'max:255'],
			'password' => ['required'],
			'legal_agreement' => ['required'], 
			]);
		$data= $request->validate([
			'scname' => ['sometimes','required', 'string', 'max:255'],
			'usname' => ['required', 'string', 'max:255'],
			'tenant' => ['sometimes','required', 'string', 'max:255'],
			'password' => ['required'],
			'legal_agreement' => ['required'], 
		]); 
		
		$checktenant=Tenant::where('id',$data['tenant'] )->first();
		 
		if($request->has('tenant')){
			if($checktenant==null){
				$tenant=Tenant::firstOrCreate([
				'id'=> $data['tenant'],
				'name'=> $request->scname,
				]);		
				$tenant->domains()->create([
				'domain'=> $data['tenant'],
				]);
			}	
		}

		if ($validator->fails()) {
		    $res= response()->json($validator->errors()->all());
			    $resp = $res->getData(true);
			return view('site.rigisterStudent',compact('resp'));
			
		} else {
		$user = new EduFacility;
		$user->name = $request->usname; 
		$user->email = $fakeEmail;
		$user->tenant_id =$request->has('tenant') ? $request['tenant'] : null;
		$user->password = Hash::make($request->password);
		$user->save();
		Auth::guard('edu_facility')->login($user, true);
		return redirect()->intended('edu-facility/users');   	 
		}

	}
	
}