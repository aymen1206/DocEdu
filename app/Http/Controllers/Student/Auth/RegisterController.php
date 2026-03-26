<?php

namespace App\Http\Controllers\Student\Auth;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new admins as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect students after registration.
     *
     * @var string
     */
    protected $redirectTo = '/student';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
  
    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
          'name' => ['required', 'string', 'max:255'],
          // 'image' => ['required','image','mimes:jpeg,png,jpg,gif','max:2048'],
          // 'certificate_image' =>['required','image','mimes:jpeg,png,jpg,gif','max:2048'],
          // 'id_image' => ['required','image','mimes:jpeg,png,jpg,gif','max:2048'],
          // 'id_number' => ['required', 'string', 'max:255'],
          // 'mobile' => ['required', 'string', 'max:255'],
          // 'country' => ['required', 'string', 'max:255'],
          // 'city' => ['required', 'string', 'max:255'],
          // 'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
          // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new student instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\Models\Student
     */
    protected function create(array $data)
    {
      dd($data);
      $student = new Student;
      $student->name = $request->name;
      $student->phone = $request->phone;
      $student->country = $request->country;
      $student->city = $request->city;
      $student->email = $request->email;
      $student->password = Hash::make($request->password);

      if ($request->has('image') == true) {
          $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
          request()->image->move(public_path('uploads/students/profile/'), $imageName);
          $student->image = 'uploads/students/'.$imageName;
      }

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

      $student->save();

    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {

        return view('student.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('student');
    }
}
