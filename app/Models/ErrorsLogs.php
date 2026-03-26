<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorsLogs extends Model
{
    use HasFactory;
    protected $table = 'errorslogs';
   protected $fillable = [
        'value'
    ];

        public static function log($value)
    {
        $user = ErrorsLogs::create(['value' => $value]);
        return $user; 
    }
}
