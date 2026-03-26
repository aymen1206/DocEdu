<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduFacilitiesType extends Model
{
    use HasFactory;
    
    public function _type(){
        
        return $this->belongsTo('App\Models\Type','type');
    }
}
