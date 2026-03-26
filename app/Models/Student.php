<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\Student\Auth\ResetPassword;
use App\Notifications\Student\Auth\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;



class Student extends Authenticatable  
{
    use  HasFactory, Notifiable, SoftDeletes, AuthenticationLoggable;
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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


    public function facilities()
    {
        return $this->hasManyThrough(
            // required
            'App\Models\EduFacility', // the related model
            'App\Models\Favorite', // the pivot model

            // optional
            'student_id', // the current model id in the pivot
            'id', // the id of related model
            'id', // the id of current model
            'facility_id' // the related model id in the pivot
        );
    }

    public function orders()
    {
      return $this->hasMany('App\Models\Order','student');
    }

    public function citys()
    {
      return $this->belongsTo('App\Models\Cities','city');
    }
    public function childrens()
    {
      return $this->hasMany('App\Models\Children','student_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
