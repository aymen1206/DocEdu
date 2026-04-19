<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;

use App\Models\FacilityPrice;
use App\Models\Order;
use App\Models\Tamaraconfig;
use App\Models\TamaraPayment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Vinkla\Hashids\Facades\Hashids;
use App\Mail\AcceptedOrdersmail;        
use App\Services\SmsService;

class OrderController extends Controller
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
     * @return Response
     */
    public function index(Request $request)
    {
        $facility['types'] = DB::table('edu_facilities_types')->where('type', $this->facility->facility_type)->get();
        $query = Order::where('orders.facility_id', $this->facility->id);

        if (isset($request->type) && $request->type != null) {

            $query->join('facility_prices', 'orders.price_id', '=', 'facility_prices.id')
                ->where('facility_prices.type', $request->type);
            $_type = $request->type;
        } else {
            $_type = null;
        }

        if (isset($request->status) && $request->status != null) {
            $query->where('orders.status', $request->status);
            $_status = $request->status;
        } else {
            $_status = null;
        }

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $query->whereBetween('orders.created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        } else {
            $_to = null;
            $_from = null;
        }

        $data = $query->select('orders.*')->orderByDesc('id')->paginate(10);


        return view('edu-facility.orders.index', compact('data', '_type', '_status', '_to', '_from', 'facility'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $data = Order::where('id', $id)->where('facility_id', auth()->guard('edu_facility')->user()->id)->first();



        if ($data->tamara == 1){
            $config = Tamaraconfig::query()->first();
            $dt = Http::withHeaders([
                'Authorization' => "Bearer $config->token"
            ])->get("$config->url/merchants/orders/reference-id/$id");
            $invoice = json_decode($dt);
        }else{
            $invoice = null;
        }

        $tamara = TamaraPayment::where('order_id',$id)->first();

        return view('edu-facility.orders.show', compact('data', 'invoice','tamara'));
    }

    

    public function autorize($id)
    {
        $config = Tamaraconfig::query()->first();
        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->post("$config->url/orders/$id/authorise");
        $info = json_decode($dt);

        $tamara = TamaraPayment::query()->where('tamaraOrderId',$id)->first();
        $order = Order::find($tamara->order_id);
        if (isset($info->status) && $info->status == 'authorised'){
            $tamara->authorised_status = $info->status;
            $tamara->order_expiry_time = $info->order_expiry_time;
            $tamara->auto_captured = $info->auto_captured;
            $tamara->capture_id = $info->capture_id;
            $tamara->update();

            $payment = Http::withHeaders([
                'Authorization' => "Bearer $config->token"
            ])->post("$config->url/payments/capture",[
                "order_id" => $id,
                "total_amount" => [
                    "amount" => $order->pricelist->price,
                    "currency" => "SAR"
                ],
                "shipping_info" => [
                    "shipped_at" => date('Y-m-d H:i:s'),
                    "shipping_company" => "DHL"
                ]
            ]);
        }

        return redirect()->back()->with('toast_success', trans('lang.update_success'));
    }
 
    public function update(Request $request)
    {
        $id=$request->id;
        $order = Order::find($id);
        $order->status = $request->status;
        $order->update();
        $st = '';
        if ($order->status == 'new') {
            $st = " جديد";
        } elseif ($order->status == 'under_revision') {
            $st = " قيد المراجعة";
        } elseif ($order->status == 'rejected') {
            $st = " مرفوض";
        } elseif ($order->status == 'accepted') {
        $st = " مقبول";
        $order = Order::find($id);
        $AdminPhone='0501235199';//0501235199

        $student=Student::find($order->student);
        $studentName=$student->name;
        $eduFacilityname=$order->facility->name;
        $phoneFormat=SmsService::convertPhoneNumber($AdminPhone);                    
        $message=" قامت مدرسة ".$eduFacilityname."  بقبول الطلب رقم ".$id." المسجل باسم ولي الامر :  " .$studentName;
	    $res=SmsService::SendMsgatSMS($phoneFormat, $message);
        
        } elseif ($order->status == 'is_paid') {
            $st = " مكتمل";
        }

        DB::table('notifications')->insert([
            'target' => 'student',
            'target_id' => $order->student,
            'title' => 'تم تغيير حالة الطلب',
            'text' => " تم تغيير حالة الطلب رقم $order->id الي $st"
        ]);
        return redirect()->back()->with('toast_success', trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\OrderController $OrderTypeController
     * @return Response
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)->where('facility_id', auth()->guard('edu_facility')->user()->id)->first();
        $order->delete();
        return redirect('edu-facility/orders')->with('toast_success', trans('lang.delete_success'));
    }
}
