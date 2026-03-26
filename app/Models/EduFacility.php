<?php

namespace App\Models;

use App\Notifications\EduFacility\Auth\ResetPassword;
use App\Notifications\EduFacility\Auth\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;  
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Comment;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;


class EduFacility extends Authenticatable  
{
    use HasFactory, Notifiable, SoftDeletes, AuthenticationLoggable;

    public function canBeRated(): bool
    {
        return true; // default false
    }
    
    public function mustBeApproved(): bool
    {
        return true; // default false
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'tenant_id'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }


   
     public function tenant()
    {
      return $this->belongsTo('App\Models\Tenant','tenant_id');
    }

    public function scopeTenanting(Builder $query): void
    {
         $query->where('tenant_id', auth()->guard('edu_facility')->user()->tenant_id);
    }

}
