<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;

use App\Models\Commission;
use App\Models\FacilityFinancialRecord;
use App\Models\Financiallog;
use App\Models\EduFacility;
use App\Models\NotCollectedOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityFinancialRecordController extends Controller
{
    private $facility;
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
        $total_orders =  Financiallog::where('facility_id',$this->facility->id)->sum('Invoice_value');
        $financialLogs = Financiallog::where('facility_id',$this->facility->id)->get()->last();;
        $total_sucscription = auth()->guard('edu_facility')->user()->orders()->where('status','is_paid')->count();
        $withdrawas = auth()->guard('edu_facility')->user()->withdrawas;
        $commission_rate = Commission::first()->commission;
        return view('edu-facility.financial-records.index',compact('total_orders','total_sucscription','commission_rate','financialLogs','withdrawas'));
    }

    public function logs()
    {
        $data = DB::table('financiallogs')->where('facility_id',$this->facility->id)->orderBy('id','desc')->paginate(10);
        return view('edu-facility.financial-records.logs',compact('data'));
    }
    
    public function logsOrders($id)
    {
        $total_orders =  Financiallog::where('facility_id',$id)->sum('Invoice_value');
        $financialLogs = Financiallog::where('facility_id',$id)->get()->last();
        $facility = EduFacility::find($id);
        $total_sucscription = $facility->orders()->where('status','is_paid')->count();
        $withdrawas = $facility->withdrawas;
        $commission_rate = Commission::first()->commission;
        $data = Financiallog::where('facility_id',$id)->orderBy('id','desc')
        ->get()
        ->takeUntil(function ($item)  {
            return $item->InvoiceId == 0;
        });
        $notcollected=NotCollectedOrders::where('facility_id',$id)->get();
       // $data = DB::table('financiallogs')->where('facility_id',$id)->orderBy('id','desc')->get();
        return view('edu-facility.financial-records.facility-logs-orders', compact('facility','data','commission_rate','withdrawas','total_sucscription','financialLogs','total_orders','notcollected'));
    
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
     * @param  \App\Models\FacilityFinancialRecord  $facilityFinancialRecord
     * @return \Illuminate\Http\Response
     */
    public function show(FacilityFinancialRecord $facilityFinancialRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacilityFinancialRecord  $facilityFinancialRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(FacilityFinancialRecord $facilityFinancialRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacilityFinancialRecord  $facilityFinancialRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacilityFinancialRecord $facilityFinancialRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacilityFinancialRecord  $facilityFinancialRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacilityFinancialRecord $facilityFinancialRecord)
    {
        //
    }
}
