<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finances extends Model
{
    use HasFactory;

      public function _city(){        
        return $this->belongsTo('App\Models\Cities','city');
    }
     public function _edu_facility(){        
        return $this->belongsTo('App\Models\EduFacility','edu_facility');
    }
}
