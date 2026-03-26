<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use App\Models\EduFacilitiesType;
use Illuminate\Http\Request;
use App\Models\FacilityPrice;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class FacilityPriceController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FacilityPrice::JOIN('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
                            ->JOIN('edu_stages','facility_prices.stage','=','edu_stages.id')
                            ->JOIN('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
                            ->where('facility_id',$this->facility->id)
                            ->select('facility_prices.*','edu_facilities_types.name as type_name','edu_stages.name as stage_name','subscription_periods.name as subscription_period_name')
                            ->paginate(10);


        return view('edu-facility.prices.index',compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['facility'] = $this->facility;

        $data['types'] = DB::table('facilities_types')->join('edu_facilities_types','facilities_types.facilities_type','edu_facilities_types.id')
                                                      ->where('facilities_types.facility_id',$this->facility->id)
                                                      ->select('edu_facilities_types.*')
                                                      ->get();

        $data['subjects'] = DB::table('subjects')->get();
        $data['subscription_periods'] = DB::table('subscription_periods')->where('type',$this->facility->facility_type)->get();
        return view('edu-facility.prices.create',compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'type' => 'required|numeric',
            'stage' => 'required|numeric',
            'price' => 'required|numeric',
            'price_discount' => 'nullable|numeric',
            'allowed_number' => 'required|numeric',
            'subscription_period' => 'required|numeric',
        ]);

        $ad = new FacilityPrice;
        $ad->facility_id = $this->facility->id;
        $ad->name = $request->name;
        $ad->name_en = $request->name_en;
        $ad->type = $request->type;
        $ad->stage = $request->stage;
        $ad->subject = $request->subject;
        $ad->price = $request->price;
        if (isset($request->price_discount)){
            $ad->price_discount = $request->price_discount;
        }else{
            $ad->price_discount = NULL;
        }
        $ad->start = $request->start;
        $ad->end = $request->end;
        $ad->subscription_period = $request->subscription_period;
        $ad->allowed_number = $request->allowed_number;
        if ($request->note != null) {
            $ad->note = $request->note;
        }
        if ($request->note_en != null) {
            $ad->note_en = $request->note_en;
        }
        $ad->save();

        return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacilityPriceController  $adAdTypeController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = FacilityPrice::JOIN('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
        ->JOIN('edu_stages','facility_prices.stage','=','edu_stages.id')
        ->JOIN('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
        ->where('facility_prices.facility_id',$this->facility->id)
        ->where('facility_prices.id',$id)
        ->select('facility_prices.*','edu_facilities_types.name as type_name','edu_stages.name as stage_name','subscription_periods.name as subscription_period_name')
        ->first();
        return view('edu-facility.prices.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['price'] = FacilityPrice::where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->first();
        $data['facility'] = $this->facility;
        $data['types'] = DB::table('edu_facilities_types')->get();
        $data['subjects'] = DB::table('subjects')->get();
        $data['subscription_periods'] = DB::table('subscription_periods')->where('type',$this->facility->facility_type)->get();
        $general = FacilityPrice::where('facility_prices.id',$id)->where('facility_prices.facility_id',$this->facility->id)->first();
        return view('edu-facility.prices.edit',compact('data','general'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        request()->validate([
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'type' => 'required|numeric',
            'price' => 'required|numeric',
            'price_discount' => 'nullable|numeric',
            'allowed_number' => 'required|numeric',
            'subscription_period' => 'required|numeric'
        ]);
        
        $id=$request->priceid;
        $ad = new FacilityPrice;


        $ad = FacilityPrice::find($id);
        $ad->facility_id = $this->facility->id;
        $ad->name = $request->name;
        $ad->name_en = $request->name_en;
        $ad->type = $request->type;
        if(!empty($request->stage)){            
        $ad->stage = $request->stage;
        }else{           
        $ad->stage = 84;
        }
        $ad->subject = $request->subject;
        $ad->price = $request->price;
        if (isset($request->price_discount)){
            $ad->price_discount = $request->price_discount;
        }else{
            $ad->price_discount = NULL;
        }
        $ad->start = $request->start;
        $ad->end = $request->end;
        $ad->subscription_period = $request->subscription_period;
        $ad->allowed_number = $request->allowed_number;
        if ($request->note != null) {
            $ad->note = $request->note;
        }
        if ($request->note_en != null) {
            $ad->note_en = $request->note_en;
        }
        $ad->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacilityPriceController  $adAdTypeController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adAd = FacilityPrice::where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->first();
       if (\DB::table('orders')->where('price_id', $adAd->id)->exists()) {
            return back()->with('toast_error', 'لا يمكن حذف السعر لأنه مرتبط بأوردارات!');
        }else{
        $adAd->delete();
        return redirect('edu-facility/prices')->with('toast_success',  trans('lang.delete_success'));
        }
    }

        public function invoice($invoice_id, $order_id)
    {
        
        $order =  Order::find($order_id);
        $client = DB::table('students')->where('id',$order->student)->first();
        $invoice = DB::table('bn_myfatoorah_payments')->where('order_id', $order->id)->where('invoice_id', $invoice_id)->first();
        $contact = DB::table('contacts')->first();
        return view('edu-facility.invoice', compact('order', 'client', 'invoice', 'contact'));

    }
}
