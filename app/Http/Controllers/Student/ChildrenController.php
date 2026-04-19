<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;



class ChildrenController extends Controller
{
    protected $student;

    public function __construct()
	{
		$this->middleware('student.auth:student');
        $this->student= auth()->guard('student')->user();
        $this->middleware('StudentPhoneVerified');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['childrens'] = DB::table('childrens')->where('student_id',$this->student->id)->get();
        $data['student'] = $this->student;
        
        return view('student.childrens.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['student'] = $this->student;
        return view('student.childrens.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$student = auth()->guard('student')->user();
		
		$validator = Validator::make($request->all(), [
		 
            'name' => ['required', 'string','max:255'],
			'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'gender' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255'],
            'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'certificate_image' =>['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'birth_date' => ['required', 'max:255'],           
               'stage' => ['required', 'max:255'], 
               'age' => ['required', 'max:255'], 
		]);

        if ($validator->fails()) {	
				$res = implode(', ', $validator->errors()->all());
				return redirect()->back()->with('toast_error', $res);			
		}

		$child = new Children;

		$child->student_id = $this->student->id;
		$child->name = $request->name;
		$child->gender = $request->gender;
        $child->age = $request->age;
        $child->stage = $request->stage; 


        if ($request->has('id_number') == true) {
        $RegisteredId =0;
        $RegisteredId = Children::where('id_number', $request->id_number)->count();      
            if($RegisteredId==0 ){
                $child->id_number = $request->id_number;
            }else{
                return redirect()->back()->with('toast_error', 'رقم الهوية مسجل من قبل');
            }
        }

        $child->birth_date = $request->birth_date;

        if ($request->has('image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/childrens/profile/'), $imageName);
            $child->image = 'uploads/childrens/profile/'.$imageName;
        }


        if ($request->has('certificate_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->certificate_image->getClientOriginalExtension();
            request()->certificate_image->move(public_path('uploads/childrens/certificate_image/'), $imageName);
            $child->certificate_image = 'uploads/childrens/certificate_image/'.$imageName;
        }

        if ($request->has('id_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->id_image->getClientOriginalExtension();
            request()->id_image->move(public_path('uploads/childrens/id_image/'), $imageName);
            $child->id_image = 'uploads/childrens/id_image/'.$imageName;
        }


		$child->save();
		return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Children  $children
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('childrens')->where('id',$id)->where('student_id',$this->student->id)->first();
        return view('student.childrens.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Children  $children
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('childrens')->where('id',$id)->where('student_id',$this->student->id)->first();
        if($data == null){
            return redirect()->back();
        }
        return view('student.childrens.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Children  $children
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
    
		$validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
			'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'gender' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255'],
            'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'certificate_image' =>['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'birth_date' => ['required', 'date', 'max:255'],
		]);

          if ($validator->fails()) {	
				$res = implode(', ', $validator->errors()->all());
				return redirect()->back()->with('toast_error', $res);			
		}

        $children=Children::find($request->ch_id);
		$child =  $children; 
        if($child->student_id != $this->student->id){
            return redirect()->back();
        }
		$child->name = $request->name;
		$child->gender = $request->gender;
		$child->id_number = $request->id_number;
		$child->birth_date = $request->birth_date;
		$child->age = $request->age;
		$child->stage = $request->stage;

        if ($request->has('image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/childrens/profile/'), $imageName);
            $child->image = 'uploads/childrens/profile/'.$imageName;
        }


        if ($request->has('certificate_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->certificate_image->getClientOriginalExtension();
            request()->certificate_image->move(public_path('uploads/childrens/certificate_image/'), $imageName);
            $child->certificate_image = 'uploads/childrens/certificate_image/'.$imageName;
        }

        if ($request->has('id_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->id_image->getClientOriginalExtension();
            request()->id_image->move(public_path('uploads/childrens/id_image/'), $imageName);
            $child->id_image = 'uploads/childrens/id_image/'.$imageName;
        }



		$child->update();
		return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Children  $children
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('childrens')->where([['student_id','=',$this->student->id],['id','=',$id]])->delete();
        return redirect()->back()->with('toast_success',  trans('lang.delete_success'));
    }

}