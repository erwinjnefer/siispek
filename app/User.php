<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name', 'email', 'password','no_wa'
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
    
    //Hash many Pekerjaan
    public function workPermit()
    {
        return $this->hasMany('App\WorkPermit');
    }
    
    public function usersUnit()
    {
        return $this->hasOne('App\UsersUnit','users_id');
    }

    public function usersUp()
    {
        return $this->hasOne('App\UsersUp');
    }
    
    
}
