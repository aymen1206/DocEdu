<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduStage extends Model
{
    use HasFactory;

    public function facility_type(){
        return $this->belongsTo('App\Models\EduFacilitiesType','type_id');
    }
}
