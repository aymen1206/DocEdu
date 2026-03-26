<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FacilityPrice extends Model
{
    use HasFactory;
    protected $appends = ['normalprice','free','booked'];
    

    public function getNormalpriceAttribute($value)
    {
        if (currency()->getUserCurrency() == "SAR") {
            return $this->price.' '.' ريال سعودي';
        }else{
            return currency($this->price,currency()->getUserCurrency());
        }        
    }


    public function getFreeAttribute($value)
    {
        if (isset(auth()->guard('edu_facility')->user()->id)) {
            $booked =  DB::table('orders')->where('price_id',$this->id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->where('status','is_paid')->count();
        }else{
            $booked =  DB::table('orders')->where('price_id',$this->id)->where('status','is_paid')->count();
        }               
        $free = $this->allowed_number - $booked;
        return $free;
    }

    public function getBookedAttribute($value)
    {
        if (isset(auth()->guard('edu_facility')->user()->id)) {
            $booked =  DB::table('orders')->where('price_id',$this->id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->where('status','is_paid')->count();
        }else{
            $booked =  DB::table('orders')->where('price_id',$this->id)->where('status','is_paid')->count();
        }  
        return   $booked;       
    }

    public function facility()
    {
        return $this->belongsTo('App\Models\EduFacility','facility_id');
    }

    public function _type()
    {
        return $this->belongsTo('App\Models\EduFacilitiesType','type');
    }

    public function _stage()
    {
        return $this->belongsTo('App\Models\EduStage','stage');
    }

    public function subscriptionperiod()
    {
        return $this->belongsTo('App\Models\SubscriptionPeriod','subscription_period');
    }



}
