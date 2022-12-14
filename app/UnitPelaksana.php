<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitPelaksana extends Model
{
    //
    protected  $table = 'unit_pelaksana';
    public $timestamps = false;

    public function unit()
    {
        return $this->hasMany('App\Unit');
    }

    public function usersUp()
    {
        return $this->hasOne('App\UsersUp');
    }
}
