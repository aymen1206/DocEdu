<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use App\Models\EduFacilities;
use App\Models\EduFacilitiesType;
use App\Models\EduFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('edu_facility.auth:edu_facility');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $data = auth()->guard('edu_facility')->user();
        return view('edu-facility.account.edit',compact('data'));
    }


    public function updateProfile(Request $request){

        $facility = auth()->guard('edu_facility')->user();

        request()->validate([
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'about' => 'required',
            'about_en' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Manger_Name'=>'required'
        ]);

        $facility->tenant->name = $request->name;
        $facility->about = $request->about;
        $facility->name_en = $request->name_en;
        $facility->about_en = $request->about_en;
        $facility->Manger_Name = $request->Manger_Name;


            if ($request->has('logo') == true) {
                $image = $request->file('logo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path("uploads/facilities/{$imageName}");
                $image->move(public_path('uploads/facilities/'), $imageName);
                $source = \Tinify\fromFile($path);
                $source->toFile($path);
                $facility->logo = 'uploads/facilities/'.$imageName;
            }
        $facility->update();


        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $edu_facility
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = auth()->guard('edu_facility')->user();
       
        $schoolname=$data->tenant_id;
        return view('edu-facility.account.edit',compact('data','schoolname'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $edu_facility
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $edu_facility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $edu_facility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $edu_facility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $edu_facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $edu_facility)
    {
        //
    }

    public function deleteSp($id){
        DB::table('specialties')->where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->delete();
        return redirect()->back()->with('toast_success',  trans('lang.delete_success'));
    }

    public function getResetPassword(){
        return view('edu-facility.account.reset-password');
    } 

    public function ResetPassword(Request $request){
        request()->validate([
            'old_password' => 'required|min:8|string',
            'password' => 'required|min:8|confirmed|string',
        ]);
        $facility = auth()->guard('edu_facility')->user();
        if (Hash::check($request->old_password, $facility->password )) {
            $facility->password = bcrypt($request->password);
            $facility->update();
            return redirect()->back()->with('toast_success',  trans('lang.update_success'));
        }else{
            return redirect()->back()->with('toast_warning','كلمة المرور القديمة غير مطابقة');
        }


    }
    
    
     public function finance()
     {
         $user = auth()->guard('edu_facility')->user();

         $business = DB::table('business')->where('facility_id', $user->id)->first();

         if ($business == null) {
             DB::table('business')->insert([
                 'facility_id' => $user->id,
                 'iban' => null,
                 'title' => "Mr",
                 'first' => null,
                 'middle' => null,
                 'last' => null,
                 'email' => null,
                 'json' => null,
             ]);
         }
         $data = DB::table('business')->where('facility_id', $user->id)->first();
         $data->facility_type = 1;
         return view('edu-facility.account.finance', compact('data'));
     }
     public function financeUpdate(Request $request)
     {
         $user = auth()->guard('edu_facility')->user();

         request()->validate([
             'iban' => 'required|min:24|max:255',
             'first' => 'required|min:1',
             'middle' => 'required|min:1',
             'last' => 'required|min:1',
             'email' => 'required|email',
             'phone' => 'required',
         ]);
         DB::table('business')
             ->where('facility_id', $user->id)
             ->update([
                 'facility_id' => $user->id,
                 'iban' => $request->iban,
                 'first' => $request->first,
                 'middle' => $request->middle,
                 'last' => $request->last,
                 'email' => $request->email,
                 'phone' => $request->phone
             ]);

         return redirect()->back()->with('toast_success', trans('lang.update_success'));
     }
}
