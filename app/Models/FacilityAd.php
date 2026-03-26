<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class FacilityAd extends Model
{
    use HasFactory;

    public function facility(){
        return $this->belongsTo('App\Models\EduFacilities','facility_id');
    }

    public function stage(){
        return $this->belongsTo('App\Models\EduStage','stage');
    }
  
    public function getCreatedAtAttribute($value)
    {
           return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
  
  public function getUpdatedAtAttribute($value)
    {
           return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
