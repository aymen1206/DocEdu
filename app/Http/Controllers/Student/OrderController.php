<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Tamaraconfig;
use App\Models\TabbyPayment;
use App\Models\JeelPayment;
use App\Models\Tabbyconfig;
use App\Models\Jeelconfig;
use Illuminate\Http\Request;
use DB;
use App\Models\EduFacility;
use App\Models\Order;
use App\Models\FacilityPrice;
use App\Models\Adminfinanciallog;
use App\Models\Commission;
use App\Models\Financiallog;
use App\Models\Tabbywebhooklog;
use App\Services\SmsService;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
	protected $student;

	public function __construct()
	{
		$this->middleware('student.auth:student');
		$this->student = auth()->guard('student')->user();
		$this->middleware('StudentPhoneVerified');
	}

	public function index()
	{ 
        

        $data =  $this->student->orders()->orderBy('id','desc')->get();
        $datacount =  $this->student->orders()->orderBy('id','desc')->count();
        $tamara_config = Tamaraconfig::query()->first();
        $tabby_config= Tabbyconfig::query()->first();
        $jeel_config= Jeelconfig::query()->first();
        if($datacount==0||$data==null){
            return redirect('/search')->with('toast_error','لا توجد طلبات سابقة ');
        }
        else{
		return view('student.orders',compact('data','tamara_config','tabby_config','jeel_config'));
        }
	}
	public function Tabbysuccess()
	{   
		$status='Tabbysuccess';
		return view('student.TabbySuccess',compact('status'));
	}
	public function Tabbycancel()
	{ 
		$status='cancel';
		return view('student.TabbyCancel',compact('status'));
	}
	public function Tabbyfailure()
	{ 
		$status='fail';
		return view('student.Tabbyfail',compact('status'));
	}
	public function JeelResponse($Oid)
	{ 
		$id='';
		$status='';
		
		if (isset($_GET['id'])) {
		$id=$_GET['id'];
		$status=$_GET['status'];
		}
		
		if (isset($_GET['requestId'])) {
		$id=$_GET['requestId'];
		$status="success";

 		$order=Order::find($Oid);
        $order->status='is_paid';
        $order->payment_type='jeel';
        $order->jeel=1;
        $order->save();


        $tp = JeelPayment::query()
            ->where('JeelOrderId', $Oid)
            ->first();
        $order = Order::find($Oid);
     



        $latest_logs = Financiallog::where('facility_id', $order->facility_id)->get()->last();

        if ($latest_logs != null) {
            $last_total = $latest_logs->total;
            $last_total_commission = $latest_logs->total_commission;
        } else {
            $last_total = 0;
            $last_total_commission = 0;
        }


        $adminlatest_logs = Adminfinanciallog::all()->last();

        if ($adminlatest_logs != null) {
            $adminlast_total = $adminlatest_logs->total;
            $adminlast_total_commission = $adminlatest_logs->total_commission;
            $final_total = $adminlatest_logs->final_total;
        } else {
            $adminlast_total = 0;
            $adminlast_total_commission = 0;
            $final_total = 0;
        }


        
        // jeel

        $totalCommission=0;
        $totalPrice=0;
        if($order->pricelist->price>=1000 && $order->pricelist->price<4999) { $totalCommission=280; }
        elseif($order->pricelist->price>=5000 && $order->pricelist->price<9999) {  $totalCommission=437; }
        elseif($order->pricelist->price>=10000 && $order->pricelist->price<19999)  { $totalCommission=700; }
        elseif($order->pricelist->price>=20000 && $order->pricelist->price<29999)  { $totalCommission=1050; }
        elseif($order->pricelist->price>=30000 && $order->pricelist->price<40000)  { $totalCommission=1400; }
        else{ $totalCommission=0;}
        $totalPrice=$order->pricelist->price+$totalCommission;

        $JeelConfig = Jeelconfig::query()->first();
        $commission_rate =$JeelConfig->Commision;
        $commission_rate_jeel =$JeelConfig->CompanyCommision;
        $commission = ($commission_rate_jeel / 100) * $totalPrice;
        $Back_from_jeel = $totalPrice-$commission;
        $EduFacility_Commision=$order->pricelist->price*($commission_rate/100);
        $EduFacility_income=$order->pricelist->price-$EduFacility_Commision;
        $PalteForm_income=$Back_from_jeel-$EduFacility_income;


        //is log exist
        $flag = Financiallog::where('InvoiceId', $Oid)->where('facility_id', $order->facility_id)->first();
        if ($flag == null) {
            // add logs to facility logs
            $financial_logs = new Financiallog;
            $financial_logs->facility_id = $order->facility_id;
            $financial_logs->InvoiceId = $order->id;
            $financial_logs->Invoice_value = $totalPrice;
            $financial_logs->text = " تم اضافة  $Back_from_jeel    ريال بعد خصم $commission_rate_jeel% من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة لجيل";
            $financial_logs->withdraw = $commission;
            $financial_logs->addition = $EduFacility_income;
            $financial_logs->commission_rate = $commission_rate_jeel;
            $financial_logs->commission = $PalteForm_income;
            $financial_logs->total = $last_total + $EduFacility_income;
            $financial_logs->total_commission = $last_total_commission + $commission;
            $financial_logs->OrderId=$order->id;
            $financial_logs->save();

            // add logs to admin logs
            $adminlog = new Adminfinanciallog;
            $adminlog->facility_id = $order->facility_id;
            $adminlog->InvoiceId = $order->id;
            $adminlog->Invoice_value = $order->pricelist->price;
            $adminlog->text = " تم اضافة  $Back_from_jeel    ريال بعد خصم $commission_rate_jeel% من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة لجيل";
            $adminlog->withdraw = $commission;
            $adminlog->addition = $EduFacility_income;
            $adminlog->commission_rate = $commission_rate_jeel;
            $adminlog->commission = $PalteForm_income;
            $adminlog->total = $adminlast_total + $EduFacility_income;
            $adminlog->total_commission = $adminlast_total_commission + $commission;
            $adminlog->final_total = $final_total + $totalPrice;
            $financial_logs->OrderId=$order->id;
            $adminlog->save();
        }



		}

		return view('student.JeelResponse',compact('status'));
	}

	public function create($facility_id,$price_list_id)
	{
		$price_list = FacilityPrice::JOIN('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
									->JOIN('edu_stages','facility_prices.stage','=','edu_stages.id')
									->JOIN('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
									->where('facility_id',$facility_id)
									->where('facility_prices.id',$price_list_id)
									->select('facility_prices.*','edu_facilities_types.name as type_name','edu_stages.name as stage_name','subscription_periods.name as subscription_period_name')
									->first();

		$facility = EduFacility::find($facility_id);
		$student =  auth()->guard('student')->user();
		return view('student.make_order',compact('student','price_list','facility'));
	}

	public function store(Request $request)
	{
     
		request()->validate([
			'price_id' => ['required', 'string', 'string', 'max:255'],
			'facility_id' => ['required', 'string', 'string', 'max:255'],
		]);


		
        $order = new Order;

        $Check=  $order->checkRepetedOrders($request->facility_id,$request->children,auth()->guard('student')->user()->id);

        if($Check){
        $order->facility_id = $request->facility_id;
        $order->student = auth()->guard('student')->user()->id;
        $order->price_id = $request->price_id;
        $order->children = $request->children;
        $order->save();
        $orderId=$order->id;
        $facilityId=$order->facility->name;
        $studentId=auth()->guard('student')->user()->name;
        $AdminPhone='0501235199';//0501235199
        $phoneFormat=SmsService::convertPhoneNumber($AdminPhone);                    
        $message="قام ولي الامر  ".$studentId." بانشاء طلب جديد بالرقم ".$orderId." لدى:  " .$facilityId;
	    $res=SmsService::SendMsgatSMS($phoneFormat, $message);


        DB::table('notifications')->insert([
            'target'=>'facility',
            'target_id'=>$order->facility_id,
            'title'=>'طلب جديد',
            'text'=>" تم انشاء طلب جديد برقم$order->id"
        ]);
          return redirect('/student/orders')->with('toast_success','تم ارسال الطلب بنجاح');
        
        }else{

            
            return redirect('/student/orders')->with('toast_error','لم تتم العملية لوجود تكرار بالطلب');
    }




	}
	
    public function cancel($id)
    { 
        $deletedOrder=Order::find($id);
        $tostType='';
        $tostData='';

        if($deletedOrder!=null){
        if($deletedOrder->status=="new" || $deletedOrder->status=="accepted" || $deletedOrder->status=="rejected"  ){
        	$deletedOrder->delete();
        $tostType='toast_success';
        $tostData='تم حذف  الطلب بنجاح';
        }
    	}else{
        $tostType='toast_error';
        $tostData='لا يوجد طلب بالرقم المحدد';
   		}
        return redirect('/student/orders')
        ->with($tostType,$tostData);
    }
    public function Pay($id,$method)
    { 
        $order =  $this->student->orders()->where('id',$id)->orderBy('id','desc')->first();         
		return view('student.Pay',compact('order','method'));                 
    }
    public function invoice($id)
    { 
        $order =  $this->student->orders()->where('id',$id)->orderBy('id','desc')->first();         
		return view('student.invoice',compact('order'));                 
    }    

}