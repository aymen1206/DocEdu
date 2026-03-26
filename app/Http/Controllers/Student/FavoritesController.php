<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoritesController extends Controller
{
	public function __construct()
	{
			$this->middleware('student.auth:student');
			$this->middleware('StudentPhoneVerified');
	}

	public function index()
	{
		$student = auth()->guard('student')->user();
		$data = $student->facilities()->where('status',1)->paginate(9);
		return view('student.favorites',compact('data'));
	}

	public function addToFavorite($id)
	{
		$fv = new Favorite;
		$fv->student_id = auth()->guard('student')->user()->id;
		$fv->facility_id = $id;
		$fv->save();
		return redirect()->back()->with('toast_success',__('lang.favorit'));
	}

	public function removeFromFavorite($id)
	{
		Favorite::where('student_id',auth()->guard('student')->user()->id)->where('facility_id',$id)->delete();
		return redirect()->back()->with('toast_success',__('lang.unfavorit'));
	}
}