<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indexcomment extends Model
{
    use HasFactory;
    
    public function _student(){
        
        return $this->belongsTo('App\Models\Student','Studentid');
    }
}
