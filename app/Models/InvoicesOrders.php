<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\EduFacility;

class InvoicesOrders extends Model
{
  protected $appends = ['normal_status'];
    use HasFactory;  
    protected $fillable = ['id','facility_id','amount'];

    public function facility()
    {
      return $this->belongsTo('App\Models\EduFacility','facility_id');
    }


}
