<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    protected  $table = 'unit';
    public $timestamps = false;

    public function workPermit()
    {
        return $this->hasMany('App\WorkPermit');
    }
    
    public function usersUnit()
    {
        return $this->hasMany('App\UsersUnit');
    }
}
