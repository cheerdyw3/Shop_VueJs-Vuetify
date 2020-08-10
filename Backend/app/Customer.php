<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = "customer";
    protected $fillable = [
         'name', 'phone', 'email','name','surname', 'password', 'address', 'district', 'amphoe', 'province', 'zipcode'
    ];

    // public function souvenir() {
    //     return $this->hasMany('App\Souvenir');
    // }
}
