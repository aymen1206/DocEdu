<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Admin\FinancialLogsController;
use App\Http\Controllers\Controller;
use App\Models\Adminfinanciallog;
use App\Models\Commission;
use App\Models\Financiallog;
use App\Models\Tabbyconfig;
use App\Models\TabbyPayment;
use App\Models\Tamaraconfig;
use App\Models\TamaraPayment;
use App\Models\EduFacility;
use App\Models\Jeelconfig;
use Exception;
use Illuminate\Http\Request;
use beinmedia\payment\Parameters\PaymentParameters;
use Illuminate\Support\Facades\Http;
use MyFatoorahPayment;
use App\Models\Order;
use Vinkla\Hashids\Facades\Hashids;
use DB;
use App\Services\TapService;
use GuzzleHttp\Client;

use Tamara\Configuration;
use Tamara\Client as TamaraClient;
use Tamara\Model\Order\Order as TmaraOrder;
use Tamara\Model\Money;
use Tamara\Model\Order\Address;
use Tamara\Model\Order\Consumer;
use Tamara\Model\Order\MerchantUrl;
use Tamara\Model\Order\OrderItemCollection;
use Tamara\Model\Order\OrderItem;
use Tamara\Model\Order\Discount;
use Tamara\Request\Checkout\CreateCheckoutRequest;
use LaravelLocalization;
class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('student.auth:student', ['except' => ['testDestinationID', 'checkPayment','tamaraNotification','TamaraCallback','TamaraCallbackCancelation']]);
        $this->middleware('StudentPhoneVerified', ['except' => ['testDestinationID', 'checkPayment','tamaraNotification','TamaraCallback','TamaraCallbackCancelation']]);
    }


    public function getPaymentMethods($order_id,  TapService $tapService)
    {   
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id);
        $gID=DB::table('students')->where('id',$order->student)->first()->guardian_id_number;  
        $firstnuminid=substr($gID,0,1);                                      
         $totPrice=0;                                   
        if($firstnuminid==1){
          $totPrice=$order->pricelist->price;
        }else{
            $totPrice=$order->pricelist->price+($order->pricelist->price*.15);
        }
        $client = auth()->guard('student')->user();
         
        $charge = $tapService->createCharge($client->name, $totPrice, 'SAR', $order->pricelist->name . ' ' . $totPrice . ' ريال سعودي ', $client->phone,"src_card");
      
        DB::table('bn_myfatoorah_payments')->insert([
                'payment_method' => 'src_card',
                'currency' => "SAR",
                'payment_url' =>  $charge['transaction']['url'],
                'invoice_status' => NULL,
                'order_id' => $order->id,
                'invoice_id' => $charge['id'],
                'invoice_value' => $totPrice,
                'customer_name' => $client->name,
                'customer_email' => $client->email,
                'customer_phone' => $client->phone,
            ]);
        header("Location:" . $charge['transaction']['url']);
        die();
    }

    public function checkPayment(Request $request , TapService $tapService)
    { 
        $invoice = $tapService->findCharge($request->tap_id);   
        $invoice_id = $request->tap_id;
 
        $flag = DB::table('bn_myfatoorah_payments')->where('invoice_id', $invoice_id)->first();

        if ($invoice['status']=='CAPTURED') {

            $order_id = $flag->order_id;

            $order = Order::find($order_id);
            $order->status = 'is_paid';
            $order->InvoiceId = $flag->invoice_id;
            $order->payment_type = 'pg';
            $order->update();

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

            $facility=EduFacility::find($order->facility_id);
            $our_commission_rate = $facility->tabcommssion;
            $commission_rate = $our_commission_rate;
            $commission = ($commission_rate / 100) * $order->pricelist->price;
            $total_after_commission = $order->pricelist->price - $commission;
            $vat=$commission * 0.15;
            $fixed_fee=1.5;
            $total_after_commission_and_vat=$total_after_commission - $vat - $fixed_fee;

   
            //is log exist
            $flag = Financiallog::where('InvoiceId', $order->InvoiceId)->where('facility_id', $order->facility_id)->first();
            if ($flag == null) {
                // add logs to facility logs
                $financial_logs = new Financiallog;
                $financial_logs->facility_id = $order->facility_id;
                $financial_logs->InvoiceId = $order->id;
                $financial_logs->Invoice_value = $order->pricelist->price;
                $financial_logs->text = " تم اضافة  $total_after_commission_and_vat   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة   بالاضافة لخصم    $fixed_fee ريال رسوم التحويل البنكي بالضافة الى  $vat ريال ضريبة العمولة ";
                $financial_logs->withdraw = 0;
                $financial_logs->addition = $total_after_commission_and_vat;
                $financial_logs->commission_rate = $commission_rate;
                $financial_logs->commission = $commission;
                $financial_logs->total = $last_total + $total_after_commission_and_vat;
                $financial_logs->total_commission = $last_total_commission + $commission;
                $financial_logs->OrderId=$order->id;
                $financial_logs->save();

                // add logs to admin logs
                $adminlog = new Adminfinanciallog;
                $adminlog->facility_id = $order->facility_id;
                $adminlog->InvoiceId = $order->id;
                $adminlog->Invoice_value = $order->pricelist->price;
                $adminlog->text = " تم اضافة  $total_after_commission_and_vat   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة  بالاضافة لخصم   $fixed_fee ريال رسوم التحويل البنكي بالضافة الى  $vat ريال ضريبة العمولة ";
                $adminlog->withdraw = $commission;
                $adminlog->addition = $total_after_commission_and_vat;
                $adminlog->commission_rate = $commission_rate;
                $adminlog->commission = $commission;
                $adminlog->total = $adminlast_total + $total_after_commission_and_vat;
                $adminlog->total_commission = $adminlast_total_commission + $commission;
                $adminlog->final_total = $final_total + $order->pricelist->price;
                $adminlog->OrderId=$order->id;
                $adminlog->save();

                DB::table('notifications')->insert([
                    'target' => 'facility',
                    'target_id' => $order->facility_id,
                    'title' => 'اضافة رصيد',
                    'text' => " تم اضافة  $total_after_commission_and_vat   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة "
                ]);

                DB::table('notifications')->insert([
                    'target' => 'student',
                    'target_id' => $order->student,
                    'title' => 'تم الدفع بنجاح واكتمال الطلب',
                    'text' => " تم الدفع بنجاح للطلب رقم  $order->id وعليه تم تغيير حالة الطلب الي مكتمل "
                ]);

            }
            $dt = 'true';
        } else {
            $dt = 'false';
        }

        return view('site.general-status', compact('dt'));
    }

    public function invoice($invoice_id, $order_id)
    {
        $client = auth()->guard('student')->user();
        $order = $data = $client->orders()->where('id', $order_id)->first();
        $invoice = DB::table('bn_myfatoorah_payments')->where('order_id', $order->id)->where('invoice_id', $invoice_id)->first();
        $contact = DB::table('contacts')->first();
        return view('student.invoice', compact('order', 'client', 'invoice', 'contact'));

    }

    public function tamaraPayment($order_id)
    {
        
        $config = Tamaraconfig::query()->first();
        if($config->status == 0){
            return redirect()->back()->with('toast_success',  trans('lang.not_available'));
        }
        $id = Hashids::decode($order_id)[0];
        $order = Order::with('pricelist')->find($id);
        $gID=DB::table('students')->where('id',$order->student)->first()->guardian_id_number;  
        $firstnuminid=substr($gID,0,1);                                                      
        $staticCommision = Commission::query()->first();
        $CommistionPrecenage=$staticCommision->our_commission/100;
        $totalcommision = $order->pricelist->price * $CommistionPrecenage;
        $total=$totalcommision+ $order->pricelist->price;
         $totPrice=0;                                   
        if($firstnuminid==1){
          $totPrice= $total;
        }else{
            $totPrice= $total+( $total*.15);
        }
        $client = auth()->guard('student')->user();

        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->post("$config->url/checkout/payment-options-pre-check", [
            "country" => "SA",
            "order_value" => [
                "amount" => $totPrice,
                "currency" => "SAR"
            ],
            "phone_number" => $client->phone,
        ]);
    
        
        $data = json_decode($dt);
        
        $error = null;
        $error_message = null;

        if (isset($data->errors)) {
            $error = $data->errors[0]->error_code;
            $error_message = $data->message;
        } else {
            $data = $data->has_available_payment_options;
        }
        return view('student.tamara', compact('data', 'error', 'error_message','order_id'));
    }

    public function Tamara($order_id)
    {
        $config = Tamaraconfig::query()->first();
        $id = Hashids::decode($order_id)[0];

        $myorder = Order::find($id);
        $gID=DB::table('students')->where('id',$myorder->student)->first()->guardian_id_number;  
        $firstnuminid=substr($gID,0,1);  
        
        
        $myclient = auth()->guard('student')->user();
        $staticCommision = Commission::query()->first();
        $CommistionPrecenage=$staticCommision->our_commission/100;
        $totalcommision = $myorder->pricelist->price * $CommistionPrecenage;
        $total=$totalcommision+ $myorder->pricelist->price;
         $totPrice=0;                                   
        if($firstnuminid==1){
          $totPrice= $total;
        }else{
            $totPrice= $total+( $total*.15);
        }

        $orderData = [];
        $order = new TmaraOrder;
        $order->setOrderReferenceId($id);
        $order->setLocale('en_US');
        $order->setCurrency('SAR');
        $order->setTotalAmount(new Money($totPrice, 'SAR'));
        $order->setCountryCode('SA');
        $order->setPaymentType('PAY_BY_INSTALMENTS');
        $order->setInstalments($config->instalments);
        $order->setDescription($myorder->pricelist->name_en);
        $order->setTaxAmount(new Money(0.00, 'SAR'));
        $order->setShippingAmount(new Money(0.00, 'SAR'));

        # order items
        $orderItemCollection = new OrderItemCollection();
        $orderItem = new OrderItem();
        $orderItem->setName($myorder->pricelist->name_en);
        $orderItem->setQuantity(1);
        $orderItem->setSku('SKU-123');
        $orderItem->setUnitPrice(new Money($totPrice, 'SAR'));
        $orderItem->setType($myorder->pricelist->name_en);
        $orderItem->setTotalAmount(new Money($totPrice, 'SAR'));
        $orderItem->setTaxAmount(new Money(0.0, 'SAR'));
        $orderItem->setDiscountAmount(new Money(0.0, 'SAR'));
        $orderItem->setReferenceId($myorder->id);

        $orderItemCollection->append($orderItem);
        $order->setItems($orderItemCollection);

        # shipping address
        $shipping = new Address();
        $shipping->setFirstName($myclient->name);
        $shipping->setLastName($myclient->name);
        $shipping->setLine1('المملكة العربية السعودية - الرياض');
        $shipping->setCity('الرياض');
        $shipping->setPhoneNumber($myclient->phone);
        $shipping->setCountryCode('SA');
        $order->setShippingAddress($shipping);

        # consumer
        $consumer = new Consumer();
        $consumer->setFirstName($myclient->name);
        $consumer->setLastName($myclient->name);
        $consumer->setEmail($myclient->email);
        $consumer->setPhoneNumber($myclient->phone);
        $order->setConsumer($consumer);

        # merchant urls
        $merchantUrl = new MerchantUrl();
        $merchantUrl->setSuccessUrl(url('/').'/tamara-success');
        $merchantUrl->setFailureUrl(url('/').'/tamara-failure');
        $merchantUrl->setCancelUrl(url('/').'/tamara-cancel');
        $merchantUrl->setNotificationUrl(url('/')."/tamara-notification");
        $order->setMerchantUrl($merchantUrl);

        # discount
        $order->setDiscount(new Discount('Coupon', new Money(0.00, 'SAR')));

        $client = TamaraClient::create(Configuration::create($config->url, $config->token));
        $request = new CreateCheckoutRequest($order);

        $response = $client->createCheckout($request);
        if (!$response->isSuccess()) {
           // $this->log($response->getErrors());
          //  return $this->handleError($response->getErrors());
            return false;
        }

        $checkoutResponse = $response->getCheckoutResponse();

        if ($checkoutResponse === null) {
           // $this->log($response->getContent());
            return false;
        }

        $tamaraOrderId = $checkoutResponse->getOrderId();
        $redirectUrl = $checkoutResponse->getCheckoutUrl();
        // do redirection to $redirectUrl

        $tp = TamaraPayment::query()
            ->where('student_id',$myclient->id)
            ->where('order_id', $myorder->id)
            ->first();

        if ($tp == null){
            $tp = new TamaraPayment;
        }

        $tp->student_id = $myclient->id;
        $tp->facility_id = $myorder->facility_id ;
        $tp->order_id = $myorder->id;
        $tp->status = 'new';
        $tp->checkout_url = $redirectUrl;
        $tp->tamaraOrderId = $tamaraOrderId;
        $tp->save();
        header("Location:" . $redirectUrl);
        die();
    }

    public function tamaraNotification(Request $request)
    {
        $token = $request->header('Authorization');
        $order_id = $request->order_id;
        $event_type = $request->event_type;
        if ($event_type === 'order_approved') {
            $this->autorize($order_id);
        }
    }


    public function autorize($id)
    {
        $config = Tamaraconfig::query()->first();

        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->post("$config->url/orders/$id/authorise");
        $info = json_decode($dt);
        $tamara = TamaraPayment::query()->where('tamaraOrderId', $id)->first();
        $order = Order::find($tamara->order_id);
        $gID=DB::table('students')->where('id',$order->student)->first()->guardian_id_number;  
        $firstnuminid=substr($gID,0,1);  
        $staticCommision = Commission::query()->first();

        $CommistionPrecenage=$staticCommision->our_commission/100;
        $totalcommision = $order->pricelist->price * $CommistionPrecenage;
        $total=$totalcommision+ $order->pricelist->price;
         $totPrice=0;                                   
        if($firstnuminid==1){
          $totPrice= $total;
        }else{
            $totPrice= $total+( $total*.15);
        }
        if (isset($info->status) && $info->status == 'authorised') {
            $tamara->authorised_status = $info->status;
            $tamara->order_expiry_time = $info->order_expiry_time;
            $tamara->auto_captured = $info->auto_captured;
            $tamara->capture_id = $info->capture_id;
            $tamara->update();

            $payment = Http::withHeaders([
                'Authorization' => "Bearer $config->token"
            ])->post("$config->url/payments/capture", [
                "order_id" => $id,
                "total_amount" => [
                    "amount" => $totPrice,
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

    public function TamaraCallback(Request $request)
    {   $order_id=$request->orderId;
        $tp = TamaraPayment::query()
            ->where('tamaraOrderId', $request->orderId)
            ->first();
        $tp->status = $request->paymentStatus;
        $tp->update();
	if($tp->status == 'declined'){
	dd("failed to verify");	
	}
        $dt = $request->paymentStatus == 'approved' ? true : false;

        if($request->paymentStatus == 'approved'){
            
        $order = Order::where('id', $tp->order_id)->first();
        $staticCommision = Commission::query()->first();
        $CommistionPrecenage=$staticCommision->our_commission/100;
        $total = $order->pricelist->price * $CommistionPrecenage;
        $order->tamara = 1;
        $order->payment_type = 'tamara';
        $order->status = 'is_paid';
        $order->update();



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

               
        // Tamara
        $staticCommision = Commission::query()->first();        
        $facility=EduFacility::find($order->facility_id);
        $our_commission_rate = $facility->tamaracommssion;
        $CommistionPrecenage=$our_commission_rate/100;
        $commission = $order->pricelist->price * $CommistionPrecenage;

        $tamraConfig = Tamaraconfig::query()->first();
        $deduction=1.5;
        if($order->pricelist->price < 2500){ $deduction=$tamraConfig->tamaradeduction; }
        $vat_from_commission = $commission * (15/100);
        $total_after_commission = 0;
        $total_after_commission = $order->pricelist->price - ($commission + $deduction + $vat_from_commission); 
        


        //is log exist
        $flag = Financiallog::where('InvoiceId', $request->orderId)->where('facility_id', $order->facility_id)->first();
        if ($flag == null) {
            // add logs to facility logs
            $financial_logs = new Financiallog;
            $financial_logs->facility_id = $order->facility_id;
            $financial_logs->InvoiceId = $order->id;
            $financial_logs->Invoice_value = $order->pricelist->price;
            $financial_logs->text = " تم اضافة  $total_after_commission   ريال بعد خصم $our_commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة   بالاضافة لخصم  $deduction ريال رسوم التحويل البنكي  بالاضافة الى  $vat_from_commission ريال ضريبة العمولة  ";
            $financial_logs->withdraw = $commission + $deduction + $vat_from_commission;
            $financial_logs->addition = $total_after_commission;
            $financial_logs->commission_rate = $our_commission_rate;
            $financial_logs->commission = $commission;
            $financial_logs->total = $last_total + $total_after_commission;
            $financial_logs->total_commission = $last_total_commission + $commission;
            $financial_logs->OrderId=$order->id;

            $financial_logs->save();

            // add logs to admin logs
            $adminlog = new Adminfinanciallog;
            $adminlog->facility_id = $order->facility_id;
            $adminlog->InvoiceId = $order->id;
            $adminlog->Invoice_value = $order->pricelist->price;
            $adminlog->text =" تم اضافة  $total_after_commission   ريال بعد خصم $our_commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة   بالاضافة لخصم  $deduction ريال رسوم التحويل البنكي  بالاضافة الى  $vat_from_commission ريال ضريبة العمولة  ";
            $adminlog->withdraw = $commission + $deduction + $vat_from_commission;
            $adminlog->addition = $total_after_commission;
            $adminlog->commission_rate = $our_commission_rate;
            $adminlog->commission = $commission;
            $adminlog->total = $adminlast_total + $total_after_commission;
            $adminlog->total_commission = $adminlast_total_commission + $commission;
            $adminlog->final_total = $final_total + $order->pricelist->price;
            $adminlog->OrderId=$order->id;
            $adminlog->save();

            DB::table('notifications')->insert([
                'target' => 'facility',
                'target_id' => $order->facility_id,
                'title' => 'اضافة رصيد',
                'text' => " تم اضافة  $total_after_commission   ريال بعد خصم $our_commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة   بالاضافة لخصم  $deduction ريال رسوم التحويل البنكي  بالاضافة الى  $vat_from_commission ريال ضريبة العمولة "
            ]);

            DB::table('notifications')->insert([
                'target' => 'student',
                'target_id' => $order->student,
                'title' => 'تم الدفع بنجاح واكتمال الطلب',
                'text' => " تم الدفع بنجاح للطلب رقم  $order->id وعليه تم تغيير حالة الطلب الي مكتمل "
            ]);
        }
        }
        return view('site.general-status',compact('dt'));
    }


    public function TamaraCallbackCancelation(Request $request){
        $tp = TamaraPayment::query()
            ->where('tamaraOrderId', $request->orderId)
            ->first();
        $tp->status = $request->paymentStatus;
        $tp->update();
        $dt = 'false';
        return view('site.general-status',compact('dt'));
    }

    public function TamaraInvoice($order_id){
        $id = Hashids::decode($order_id)[0];
        $client = auth()->guard('student')->user();
        $order = $data = $client->orders()->where('id', $id)->first();
        $contact = DB::table('contacts')->first();
        $tamara_payment = TamaraPayment::query()->where('order_id',$id)->first();
        $config = Tamaraconfig::query()->first();

        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->get("$config->url/merchants/orders/reference-id/$id");
        $invoice = json_decode($dt);
        return view('student.tamara_invoice', compact('order', 'client', 'contact','invoice'));
    }


    public function alrajhiInstallements($order_id){
        $order_id = Hashids::decode($order_id)[0];
        $text =  DB::table('legal_agreements')->where('type', 'alrajhi-installments')->first();
        $data = ["order_id" => Hashids::encode($order_id), "text" => $text];
        return view('student.alrajhi-installments', compact('data'));
    }

    
    public function createAlrajhiInstallements(Request $request){
        $order_id = Hashids::decode($request->order_id)[0];
        $user = auth()->guard('student')->user();
        $order = Order::find($order_id);
        $order->payment_type = 'alrajhi_inst';
        $order->status='under_revision';
        $order->save();
        $data = ['status' => "success"];
        return view('student.alrajhi-installments', compact('data'));

    }



    public function TabbyPreScoring($order_id)
    {   
        $config = Tabbyconfig::query()->first();    
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id);
         $gID=DB::table('students')->where('id',$order->student)->first()->guardian_id_number;  
        $firstnuminid=substr($gID,0,1);  
        $staticCommision = Commission::query()->first();
         $CommistionPrecenage=$staticCommision->our_commission/100;
        $totalcommision = $order->pricelist->price * $CommistionPrecenage;
        $total=$totalcommision+ $order->pricelist->price;
         $totPrice=0;                                   
        if($firstnuminid==1){
          $totPrice= $total;
        }else{
            $totPrice= $total+( $total*.15);
        }
        $client = auth()->guard('student')->user();
        $date=date('yy-m-d');
        $time=date('h:m:s');
        $now=$date."T".$time."Z";
        $lang="";
        if(LaravelLocalization::getCurrentLocale()  == 'en'){ $lang="en";}
        else{  $lang="ar"; }
        $dt = Http::withHeaders([
            'Authorization' => "Bearer ".$config->token,
            'Content-Type' => 'application/json' 
        ])->post($config->url, [
            "payment" => [
                "amount" => $totPrice,
                "currency" => "SAR",
                "description" =>"Pay Edu-Facility installment",
                "buyer" => [
                      "phone"=> $client->phone,
                      "email"=> $client->email,
                      "name"=> $client->name
                ],
                "shipping_address" => [
                  "city"=> "الرياض",
                  "address"=> "المملكة العربية السعودية - الرياض",
                  "zip"=> "00000"
                ],
                "order" => [
                  "tax_amount"=> "0.00",
                  "shipping_amount"=> "0.00",
                  "discount_amount"=> "0.00",
                  "updated_at"=> $order->updated_at,
                  "reference_id"=> (string)$id,
                   "items" =>[
                    [
                    "title"=> $order->facility->name,
                    "description"=>$order->pricelist->name_en,
                    "quantity"=> 1,
                    "unit_price"=> $totPrice,
                    "discount_amount"=> "0.00",
                    "reference_id"=> (string)$id,
                    "category"=> $order->pricelist->subscriptionperiod->name,

                    ]
                    ]
                  ],                              
                "buyer_history" => [
                  "registered_since" => $client->created_at,
                  "loyalty_level" => 0,
                ],
                "order_history" => [  
                    [                     
                    "purchased_at"=> $now,
                    "amount" => $totPrice,
                    "status" => "new",
                    ]
                ],
                "meta" => [
                  "order_id" => $id,
                  "customer" => $client->id
                ]
            ],
            
            "lang" =>$lang,
            "merchant_code"=>$config->merchant_id,
            "merchant_urls"=>[
            "success"=>url('/')."/student/tabby-success/".$id,
            "cancel"=>url('/')."/student/tabby-cancel",
            "failure"=>url('/')."/student/tabby-failure"
            ], 
        ]);

        $response=$dt->json();
        $CheckoutStatus=$response['status'];
        if($CheckoutStatus=="created"){    return redirect('student/tabby/'.$order_id);       }
        else{ return view('student.TabbyPre-Scoring'); }
     }
     
    public function tabbyPayment($order_id)
    {   
        
        $config = Tabbyconfig::query()->first();    
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id); 
        $gID=DB::table('students')->where('id',$order->student)->first()->guardian_id_number;  
        $firstnuminid=substr($gID,0,1);  
        $staticCommision = Commission::query()->first();
        
        $CommistionPrecenage=$staticCommision->our_commission/100;
        $totalcommision = $order->pricelist->price * $CommistionPrecenage;
        $total=$totalcommision+ $order->pricelist->price;
         $totPrice=0;                                   
        if($firstnuminid==1){
          $totPrice= $total;
        }else{
            $totPrice= $total+( $total*.15);
        }

        $client = auth()->guard('student')->user();
        $date=date('yy-m-d');
        $time=date('h:m:s');
        $now=$date."T".$time."Z";
        $lang="";
        if(LaravelLocalization::getCurrentLocale()  == 'en'){ $lang="en";}
        else{  $lang="ar"; }

        $dt = Http::withHeaders([
            'Authorization' => "Bearer ".$config->token,
            'Content-Type' => 'application/json' 
        ])->post($config->url, [
            "payment" => [
                "amount" => $totPrice,
                "currency" => "SAR",
                "description" =>"Pay Edu-Facility installment",
                "buyer" => [
                      "phone"=> $client->phone,
                      "email"=> $client->email,
                      "name"=> $client->name
                ],
                "shipping_address" => [
                  "city"=> "الرياض",
                  "address"=> "المملكة العربية السعودية - الرياض",
                  "zip"=> "00000"
                ],
                "order" => [
                  "tax_amount"=> "0.00",
                  "shipping_amount"=> "0.00",
                  "discount_amount"=> "0.00",
                  "updated_at"=> $order->updated_at,
                  "reference_id"=> (string)$id,
                   "items" =>[
                    [
                    "title"=> $order->facility->name,
                    "description"=>$order->pricelist->name_en,
                    "quantity"=> 1,
                    "unit_price"=> $totPrice,
                    "discount_amount"=> "0.00",
                    "reference_id"=> (string)$id,
                    "category"=> $order->pricelist->subscriptionperiod->name,

                    ]
                    ]
                  ],                              
                "buyer_history" => [
                  "registered_since" => $client->created_at,
                  "loyalty_level" => 0,
                ],
                "order_history" => [  
                    [                     
                    "purchased_at"=> $now,
                    "amount" => $totPrice,
                    "status" => "new",
                    ]
                ],
                "meta" => [
                  "order_id" => $id,
                  "customer" => $client->id
                ]
            ],
            
            "lang" =>$lang,
            "merchant_code"=>$config->merchant_id,
            "merchant_urls"=>[
            "success"=>url('/')."/student/tabby-success/".$id,
            "cancel"=>url('/')."/student/tabby-cancel",
            "failure"=>url('/')."/student/tabby-failure"
            ], 
        ]);

        $response=$dt->json();


      $Webhookurl=config('app.url')."/api/tabby/webhook/";
        $webhookdt = Http::withHeaders([
            'Authorization' => "Bearer ".$config->secretKeyToken,
            'X-Merchant-Code' =>$config->merchant_id,
            'Content-Type' => 'application/json' 
        ])->post($config->webhookapi, 
            [
                      "url"=> $Webhookurl,
                      "is_test"=> false
                ]);



        $CheckouId=$response['id'];
        $CheckoutStatus=$response['status'];
        $redirectUrl=$response['configuration']['available_products']['installments'][0]['web_url']; 
        $next_payment_date=$response['configuration']['available_products']['installments'][0]['installments'][0]['due_date'];

        DB::table('tabby_payments')->insert([
            'student_id'=>$client->phone,
            'facility_id'=>$order->facility_id,
            'order_id'=>$id,
            'checkout_url'=>$redirectUrl,
            'tabbyOrderId'=>$CheckouId,
            'authorised_status'=>"Autorized",
            'can_authorised'=>"",
            'order_expiry_time'=>$next_payment_date,
            'auto_captured'=>null,
            'capture_id'=>null
        ]);
        header("Location:" . $redirectUrl);
        die();  
     }
      public function jeelPay($order_id){
        $totalCommission=0;
        $totalPrice=0;
        $config = Jeelconfig::query()->first();   
        $response = Http::asForm()->post($config->Authurl, [
        'grant_type' => 'client_credentials',
        'client_id' => $config->client_id,
        'client_secret' => $config->client_secret,
        'scope' => '',
        ]);         
        $token=$response->json()['access_token'];

        if (isset($token) ) {
        $config->token=$token;
        $config->save();  
        $id = Hashids::decode($order_id)[0];
        $order = Order::find($id);
 
        $gID=DB::table('students')->where('id',$order->student)->first()->guardian_id_number;  
        $firstnuminid=substr($gID,0,1);  
        if($order->pricelist->price>=1000 && $order->pricelist->price<4999) $totalCommission=280;
        if($order->pricelist->price>=5000 && $order->pricelist->price<9999) $totalCommission=437;
        if($order->pricelist->price>=10000 && $order->pricelist->price<19999) $totalCommission=700;
        if($order->pricelist->price>=20000 && $order->pricelist->price<29999) $totalCommission=1050;
        if($order->pricelist->price>=30000 && $order->pricelist->price<40000) $totalCommission=1400;
        $total=$order->pricelist->price+$totalCommission;
            $totalPrice=0;                                   
        if($firstnuminid==1){
          $totalPrice= $total;
        }else{
            $totalPrice= $total+( $total*.15);
        }
        $existChild=DB::table('childrens')->where('id',$order->children)->first();
        if($existChild!=null){
        $Studentname=DB::table('childrens')->where('id',$order->children)->first()->name;
        }else{

               $error="noChiled";

                return view('student.jeel-installments-Error', compact('error'));
        }
        $client = auth()->guard('student')->user();
        $phoneNumber=substr($client->phone, 3, 9);
        $dt = Http::withHeaders([
            'Authorization' => "Bearer ".$token
            ])->post($config->url, [
            "school_name"=>$order->facility->name,
            "customer"=>[
            "first_name"=>$Studentname,
            "last_name"=>$client->name,
            "phone_number"=> $phoneNumber,
            "national_id"=> $client->guardian_id_number,
            "email"=>$client->email,
            ], 
            "students"=>
        [
            [
            "national_id"=>$client->id_number,
            "entity_id"=> "a86cc409-aa9f-4a37-9d74-5d914b6e1c82",//sandbox use: 7734934a-944c-421f-a00d-f2ba6dd36a4c
            "academic_year"=> "2025",
            "is_currently_enrolled"=>true,
            "name"=>$Studentname,
            "grade"=>$order->pricelist->_stage->name,
            "cost"=>$totalPrice,
            ]
        ]
            , 
            "urls"=>[
            "redirect_url"=>url('/')."/student/Jeel-Payment/".$id,
            "notification_url"=>"https://theedukey.com/api/jeel/webhook/",
            ], 

            ]);

        $response=$dt->json();
    
         if(isset($response['redirect_url'])){
               
                $redirectUrl=$response['redirect_url'];
                $CheckouId=$response['id'];
                $Creationdate=$response['creation_date'];

                DB::table('Jeel_payments')->insert([
                    'student_id'=>$client->id,
                    'facility_id'=>$order->facility_id,
                    'order_id'=>$id,
                    'checkout_url'=>$redirectUrl,
                    'jeelOrderId'=>$CheckouId,
                    'status'=>"success",
                    'Jeel_response'=>$dt,
                    'created_at'=>$Creationdate
                ]);

               header("Location:" . $redirectUrl);
                die();

            }
            else{

             redirect()->back();
               $error=$response['errors'][0]['id'];

                return view('student.jeel-installments-Error', compact('error'));
               

             }
             
                

         } 
     }


}
