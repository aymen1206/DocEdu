<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Children;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Services\SmsService;
use Auth;

class CustomAuthcontroller extends Controller
{
     public function __construct()
    {
        $this->middleware('student.auth')->except('register');
        $this->middleware('StudentPhoneVerified')->except('register');
    }

	public function profile()
	{
		$student = auth()->guard('student')->user();
		return view('student.profile',compact('student'));
	}

	public function register(Request $request)
	{ 

		
		$validator = Validator::make($request->all(), [
			'scname' => ['required', 'string', 'max:255'],
			'usname' => ['required', 'string', 'max:255'],
			'tenant' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'max:255'],
			'password' => ['required'],
			'legal_agreement' => ['required'], 
			]);
		$data= $request->validate([
			'scname' => ['required', 'string', 'max:255'],
			'usname' => ['required', 'string', 'max:255'],
			'tenant' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'max:255'],
			'password' => ['required'],
			'legal_agreement' => ['required'], 
		]); 
		$tenant=Tenant::firstOrCreate([
		'id'=> $data['tenant'],
		'name'=> $request->scname,
		]);
		$tenant->domains()->create([
		'domain'=> $data['tenant'],
		]);
		if ($validator->fails()) {
		    $res= response()->json($validator->errors()->all());
			    $resp = $res->getData(true);
			return view('site.rigisterStudent',compact('resp'));
			
		} else {
		$user = new User;
		$user->name = $request->usname; 
		$user->email = $request->email;
		$user->tenant_id = $tenant->id;
		$user->password = Hash::make($request->password);
		$user->save();
		Auth::guard('edu_facility')->login($user, true);
		return redirect()->intended('edu-facility');   	 
		}

	}
 

	public function ganrateCode($phone){
			$verifcationCode=0;
			$randomNumber = rand(1000, 9999);
			//write code
			$st=Student::select('*')->where('phone',$phone)->first();
			if($st!=null){
			$st->phone_verify=$randomNumber;
			$st->save();			
			//read code
			$stu=Student::select('phone_verify')->where('phone',$phone)->first();
			$verifcationCode=$stu->phone_verify;
			return $verifcationCode;
			}			
			$fac=EduFacility::select('*')->where('phone',$phone)->first();
			if($fac!=null){
			$fac->phone_verify=$randomNumber;
			$fac->save();			
			//read code
			$faci=EduFacility::select('phone_verify')->where('phone',$phone)->first();
			$verifcationCode=$faci->phone_verify;
			return $verifcationCode;
			}	

	}
	

	public function VirifyloginStudent(Request $request)
	{
		$phone = $request->phone;
		$code = $request->code;
		$st=Student::select('*')->where('phone',$phone)->first();	
			if($code==$st->phone_verify){		
   				Auth::guard('student')->login($st, true);
				return redirect()->intended('student');
			}else{
				return redirect()->back()->with('toast_error',  trans('auth.failed'));
			}	
	}


	public function RegistrationForm(Request $request)
	{ 
		$student = auth()->guard('student')->user();
		
		$validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
            'nameEn' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
			'PID' => ['required', 'string', 'max:255'],
			'PIDP' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'Fcard' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'city' => ['required', 'string', 'max:255'],
			'type' => ['required', 'string', 'max:255'],
            'age' => ['required', 'string', 'max:255'],
			'profile' =>['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'certificate' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'idNumber' =>  ['required', 'string', 'max:255'],
			'idphoto' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		]);
		if ($validator->fails()) {	
				$res = implode(', ', $validator->errors()->all());
				return redirect()->back()->with('toast_error', $res);			
		}
		
		$student->name = $request->name;
      	$student->name_en = $request->nameEn;
      	$student->phone = $request->phone;
		$student->city = $request->city;				
		$student->id_number = $request->PID;
	    $student->guardian_id_number = $request->PID;
		 
         


		if ($request->has('Fcard') == true) {
			$imageName = time().rand(1,10000).'.'.request()->Fcard->getClientOriginalExtension();
			request()->Fcard->move(public_path('uploads/students/family_id_image/'), $imageName);
			$student->family_id_image = 'uploads/students/family_id_image/'.$imageName;
		}


		if ($request->has('PIDP') == true) {
			$imageName = time().rand(1,10000).'.'.request()->PIDP->getClientOriginalExtension();
			request()->PIDP->move(public_path('uploads/students/id_image/'), $imageName);
			$student->id_image = 'uploads/students/id_image/'.$imageName;
		}

		
		$child = new Children;

		$child->student_id = $student->id;
		$child->name = $request->child_name;
		$child->name_en = $request->child_name;
		$child->gender = $request->type;



        if ($request->has('idNumber') == true) {
        $RegisteredId =0;
        $RegisteredId = Children::where('id_number', $request->idNumber)->count();      
            if($RegisteredId==0 ){
                $child->id_number = $request->idNumber;
            }else{
                return redirect()->back()->with('toast_error', 'رقم الهوية الابن مسجل من قبل');
            }
        }

        $child->birth_date = $request->d_o_B;
        $child->age = $request->age;
        $child->stage = $request->stage; 
	 
		
		if ($request->hasFile('profile')) {
			$file = $request->file('profile');
			$imageName = time().rand(1,10000).'.'.$file->getClientOriginalExtension();

			// المسار الأساسي
			$mainPath = public_path('uploads/students/profile/');
			$secondPath = public_path('uploads/childrens/profile/');

			// تأكد إن المجلدات موجودة
			if (!file_exists($mainPath)) {
				mkdir($mainPath, 0755, true);
			}
			if (!file_exists($secondPath)) {
				mkdir($secondPath, 0755, true);
			}

			// أول عملية نقل
			$file->move($mainPath, $imageName);

			// بعد النقل انسخ الصورة للمجلد التاني
			copy($mainPath.$imageName, $secondPath.$imageName);

			// خزن المسارات في قاعدة البيانات
			$student->image = 'uploads/students/profile/'.$imageName;
			$child->image = 'uploads/childrens/profile/'.$imageName;
		}

		
		if ($request->hasFile('certificate')) {
			$file = $request->file('certificate');
			$imageName = time().rand(1,10000).'.'.$file->getClientOriginalExtension();

			// المسار الأساسي
			$mainPath = public_path('uploads/students/certificate_image/');
			$secondPath = public_path('uploads/childrens/certificate_image/');

			// تأكد إن المجلدات موجودة
			if (!file_exists($mainPath)) {
				mkdir($mainPath, 0755, true);
			}
			if (!file_exists($secondPath)) {
				mkdir($secondPath, 0755, true);
			}

			// أول عملية نقل
			$file->move($mainPath, $imageName);

			// بعد النقل انسخ الصورة للمجلد التاني
			copy($mainPath.$imageName, $secondPath.$imageName);

			// خزن المسارات في قاعدة البيانات
			$student->certificate_image = 'uploads/students/certificate_image/'.$imageName;
			$child->certificate_image = 'uploads/childrens/certificate_image/'.$imageName;
		}
       
        if ($request->has('idphoto') == true) {
            $imageName = time().rand(1,10000).'.'.request()->idphoto->getClientOriginalExtension();
            request()->idphoto->move(public_path('uploads/childrens/id_image/'), $imageName);
            $child->id_image = 'uploads/childrens/id_image/'.$imageName;
        }

        try {
            $student->update();			
			$child->save();
            return redirect()->back()->with('toast_success', trans('lang.update_success'));

        } catch (Exception $e) {
			
			return redirect()->back()->with('toast_error',  $e);
        }

	}



	public function updateProfile(Request $request)
	{
		$student = auth()->guard('student')->user();

		  
		$validator = Validator::make($request->all(), [
			'arabname' => ['required', 'string', 'max:255'],
            'engname' => ['required', 'string', 'max:255'],
			'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'], 
			'idphoto' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'familyCard' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'idnum' => ['nullable', 'string', 'max:255'], 
            'phone' => ['required', 'string', 'regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
			'city' => ['required'],
		]);

		if ($validator->fails()) {	
				$res = implode(', ', $validator->errors()->all());
				return redirect()->back()->with('toast_error', $res);			
		}
		$student->name = $request->arabname;
      	$student->name_en = $request->engname;
      	$student->phone = $request->phone;
		$student->city = $request->city;
		 

		if ($request->has('idnum') == true) {
		 
			    $student->id_number = $request->idnum;
	            $student->guardian_id_number = $request->idnum;
        	 
        }

		if ($request->has('image') == true) {
				$imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
				request()->image->move(public_path('uploads/students/profile/'), $imageName);
				$student->image = 'uploads/students/profile/'.$imageName;
		}

		if ($request->has('familyCard') == true) {
			$imageName = time().rand(1,10000).'.'.request()->familyCard->getClientOriginalExtension();
			request()->familyCard->move(public_path('uploads/students/family_id_image/'), $imageName);
			$student->family_id_image = 'uploads/students/family_id_image/'.$imageName;
		}

		if ($request->has('idphoto') == true) {
			$imageName = time().rand(1,10000).'.'.request()->idphoto->getClientOriginalExtension();
			request()->idphoto->move(public_path('uploads/students/id_image/'), $imageName);
			$student->id_image = 'uploads/students/id_image/'.$imageName;
		}

        try {

            $student->update();
            return redirect()->back()->with('toast_success', trans('lang.update_success'));

        } catch (Exception $e) {
			
            return redirect()->back()->with('toast_error',  $e);
        }

	}

	public function completeAccountData(Request $request)
    {

		$student = auth()->guard('student')->user();

		request()->validate([
		  'family_id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'guardian_id_number' => ['nullable', 'string', 'max:255'],
		]);


		if ($request->has('family_id_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->family_id_image->getClientOriginalExtension();
			request()->family_id_image->move(public_path('uploads/students/family_id_image/'), $imageName);
			$student->family_id_image = 'uploads/students/family_id_image/'.$imageName;
		}

		$student->update();
		return redirect()->back()->with('toast_success',  trans('lang.update_success'));

    }

	public function completeAccountOrder(Request $request)
    {
		$student = auth()->guard('student')->user();

		request()->validate([
		  'certificate_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'id_number' => ['nullable', 'string', 'max:255'],
		]);

		$student->guardian_id_number = $request->guardian_id_number;

		if ($request->has('certificate_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->certificate_image->getClientOriginalExtension();
			request()->certificate_image->move(public_path('uploads/students/certificate_image/'), $imageName);
			$student->certificate_image = 'uploads/students/certificate_image/'.$imageName;
		}

		if ($request->has('id_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->id_image->getClientOriginalExtension();
			request()->id_image->move(public_path('uploads/students/id_image/'), $imageName);
			$student->id_image = 'uploads/students/id_image/'.$imageName;
		}
		$student->id_number = $request->id_number;
		$student->update();
		return redirect()->back()->with('toast_success',  trans('lang.update_success'));

    }
	 

}
