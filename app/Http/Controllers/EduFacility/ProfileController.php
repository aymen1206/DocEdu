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

        $data2 = DB::table('types')->get();

        $current_types = DB::table('facilities_types')
                    ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
                    ->select('edu_facilities_types.*')
                    ->where('facility_id',$data->id)
                    ->get();
            $current_types_ids=[];
        foreach($current_types as $key => $ct){
            $current_types_ids[$key] = $ct->id;
        }

        $data3 = DB::table('edu_facilities_types')
                    ->select('edu_facilities_types.*')
                    ->where('type',$data->facility_type)
                    ->whereNotIn('edu_facilities_types.id',$current_types_ids)
                    ->get();


        $data4 = DB::table('facilities_center_types')
            ->join('center_types','facilities_center_types.center_type_id','=','center_types.id')
            ->select('center_types.*')
            ->where('facility_id',$data->id)
            ->get();

        $teacher_types = DB::table('facilities_types')
            ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
            ->select('edu_facilities_types.*')
            ->where('facility_id',$data->id)
            ->get();

        return view('edu-facility.account.edit',compact('data','data2','data3','data4','teacher_types','current_types'));
    }


    public function updateProfile(Request $request){

        $facility = auth()->guard('edu_facility')->user();

        request()->validate([
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'about' => 'required',
            'about_en' => 'required',
            'type_id' => 'nullable',
            'phone' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|min:2|max:255|unique:students|unique:admins|unique:edu_facilities,email,'.$facility->id,
            'city' => 'required',
            'address' => 'required',
            'map_location' => 'required',
            'commercial_record' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sp_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'teacher_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $facility->name = $request->name;
        $facility->about = $request->about;
        $facility->name_en = $request->name_en;
        $facility->about_en = $request->about_en;
        $facility->facility_type = $request->type_id;
        $facility->phone = $request->phone;
        $facility->mobile = $request->mobile;
        $facility->email = $request->email;
        $facility->city = $request->city;
        $facility->address = $request->address;
        $facility->address_en = $request->address;
        $facility->map_location = $request->map_location;


            if ($request->has('commercial_record') == true) {
                $image = $request->file('commercial_record');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path("uploads/facilities/{$imageName}");
                $image->move(public_path('uploads/facilities/'), $imageName);
                $source = \Tinify\fromFile($path);
                $source->toFile($path);
                $facility->commercial_record = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('owner_id') == true) {
                $image = $request->file('owner_id');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path("uploads/facilities/{$imageName}");
                $image->move(public_path('uploads/facilities/'), $imageName);
                $source = \Tinify\fromFile($path);
                $source->toFile($path);
                $facility->owner_id = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('logo') == true) {
                $image = $request->file('logo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path("uploads/facilities/{$imageName}");
                $image->move(public_path('uploads/facilities/'), $imageName);
                $source = \Tinify\fromFile($path);
                $source->toFile($path);
                $facility->logo = 'uploads/facilities/'.$imageName;
            }



            if ($request->has('teacher_id') == true) {
                $image = $request->file('teacher_id');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path("uploads/facilities/{$imageName}");
                $image->move(public_path('uploads/facilities/'), $imageName);
                $source = \Tinify\fromFile($path);
                $source->toFile($path);
                $facility->teacher_id = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('sp_image') == true) {
                $image = $request->file('sp_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path("uploads/facilities/{$imageName}");
                $image->move(public_path('uploads/facilities/'), $imageName);
                $source = \Tinify\fromFile($path);
                $source->toFile($path);
                $facility->sp_image = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('profile_image') == true) {
                $image = $request->file('profile_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path("uploads/facilities/{$imageName}");
                $image->move(public_path('uploads/facilities/'), $imageName);
                $source = \Tinify\fromFile($path);
                $source->toFile($path);
                $facility->profile_image = 'uploads/facilities/'.$imageName;
            }


        $facility->update();

        //edu
        if ($request->facility_types){

            DB::table('facilities_types')->where('facility_id',$facility->id)->delete();
            foreach ($request->facility_types as $type){

                DB::table('facilities_types')->insert(['facility_id' => $facility->id , 'facilities_type' => $type ]);
            }

        }


        if (isset($request->specialties_group)){
            foreach ($request->specialties_group as $key => $group){
                if (isset($group['title'])){
                    $title = $group['title'];
                }else{
                    $title = '';
                }

                if (isset($group['file'])){
                    $file = $group['file'];
                    $imageName = time().rand(1,10000).'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/specialties/'), $imageName);
                    $sp_image_name = 'uploads/specialties/'.$imageName;
                }else{
                    $sp_image_name = '';
                }

                if ($title != ''){
                    DB::table('specialties')->insert(['facility_id' => $facility->id , 'title' =>$title , 'image' =>$sp_image_name ]);
                }
            }
        }

        //center
        if ($request->center_types){
            DB::table('facilities_center_types')->where('facility_id',$facility->id)->delete();
            foreach ($request->center_types as $ct){
                DB::table('facilities_center_types')->insert(['facility_id' => $facility->id , 'center_type_id' =>$ct ]);
            }
        }

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
        $current_types = DB::table('facilities_types')
            ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
            ->select('edu_facilities_types.*')
            ->where('facility_id',$data->id)
            ->get();

        return view('edu-facility.account.show',compact('data','current_types'));
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
