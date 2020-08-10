<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $table = "member";
    protected $fillable = [
         'name', 'shop', 'phone', 'email', 'password', 'address', 'district', 'amphoe', 'province', 'zipcode','region_id','image'
    ];

    public function souvenir() {
        return $this->hasMany('App\Souvenir');
    }

    public function delivery() {
        return $this->hasMany('App\MemberDelivery')->with('weight')->with('detail');

    }
    // public function delivery() {
    //     return $this->hasMany('App\MemberDelivery')->with('weight')->with('detail');

    // }
}
