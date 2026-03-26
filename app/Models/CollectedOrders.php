<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Student;
use App\Models\EduFacility;
use App\Mail\NotifyCompletedOrederViaEmail;
use App\Services\SmsService;

class CollectedOrders extends Model
{
  protected $appends = ['normal_status'];
    use HasFactory;  
    protected $fillable = [
        'id','facility_id', 'student', 'children','price_id','InvoiceId','payment_type','tamara', 'tabby',	'jeel', 'rate'];

    public function facility()
    {
      return $this->belongsTo('App\Models\EduFacility','facility_id');
    }

    public function studentdata()
    {
      return $this->belongsTo('App\Models\Student','student');
    }

    public function childrendata()
    {
      return $this->belongsTo('App\Models\Children','children');
    }

    public function pricelist()
    {
      return $this->belongsTo('App\Models\FacilityPrice','price_id');
    }
    
   
    public function payment_type()
    {
      $st = '';
      if ($this->payment_type == 'alrajhi_inst') {
        $st = 'تمويل الراجحي';
      }elseif ($this->payment_type == 'pg') {
        $st = 'الدفع بالكامل عن طريق تاب';
      }elseif ($this->payment_type == 'tamara') {
        $st = 'التقسيط عن طريق تمارا';
       }elseif ($this->payment_type == 'tabby') {
        $st = 'التقسيط عن طريق تابي';
      }elseif ($this->payment_type == 'jeel') {
        $st = 'التقسيط عن طريق جيل';
      }
      return $st;
    }



    

}
