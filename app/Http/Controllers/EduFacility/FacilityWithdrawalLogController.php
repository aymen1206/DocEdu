<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;

use App\Models\FacilityFinancialRecord;
use App\Models\InvoicesOrders;
use App\Models\Financiallog;
use App\Models\CollectedOrders;
use Illuminate\Http\Request;

class FacilityWithdrawalLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('edu_facility.auth:edu_facility');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data = InvoicesOrders::where('facility_id',auth()->guard('edu_facility')->user()->id)->paginate(10);
        return view('edu-facility.withdrawal-logs.index',compact('data'));
    }
  
    public function invoicedetails($invoice_id)
    {        
        $data = CollectedOrders::where('InvoiceId',$invoice_id)->get();                
        return view('edu-facility.withdrawal-logs.invoicedetails', compact('data','invoice_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dt = Financiallog::where('facility_id',auth()->guard('edu_facility')->user()->id)->get()->last();
        if($dt == null || $dt->total == 0|| $dt->total == ""){
           return redirect()->back()->with('toast_error','عفوا ليس لديك رصيد كافي لانشاء طلب سحب');
        }
        return view('edu-facility.withdrawal-logs.create',compact('dt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'bank' => 'required|min:2|max:255',
            'account_name' => 'required|min:5',
            'account_number' => 'required|min:5',
        ]);
        $total = Financiallog::where('facility_id',auth()->guard('edu_facility')->user()->id)->get()->last()->total;
        $withdrawal = new FacilityWithdrawalLog;
        $withdrawal->facility_id = auth()->guard('edu_facility')->user()->id;
        $withdrawal->bank = $request->bank;
        $withdrawal->account_name = $request->account_name;
        $withdrawal->account_number =$request->account_number;

        if($total == null || $total == ""){
        $withdrawal->total = 0;
        }
        else{
             $withdrawal->total = $total;
        }
        $withdrawal->save();

        return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FacilityWithdrawalLog  $facilityWithdrawalLog
     * @return \Illuminate\Http\Response
     */
    public function show(FacilityWithdrawalLog $facilityWithdrawalLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FacilityWithdrawalLog  $facilityWithdrawalLog
     * @return \Illuminate\Http\Response
     */
    public function edit(FacilityWithdrawalLog $facilityWithdrawalLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FacilityWithdrawalLog  $facilityWithdrawalLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacilityWithdrawalLog $facilityWithdrawalLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacilityWithdrawalLog  $facilityWithdrawalLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacilityWithdrawalLog $facilityWithdrawalLog)
    {
        //
    }
}
