<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersDetail extends Model
{
    //
    protected $table = "OrdersDetail";
    protected $fillable = [
        'order_id','member_id','unit_id','souvenir_group_id','name','price','amount','weight','description','deliveryId','deliveryName','deliveryPrice','image','discount','totalPrice','created_at','updated_at'
    ];

    public function Unit() {
        return $this->hasOne('App\Unit','id','unit_id');
    }

    public function souvenir_group() {
        return $this->hasOne('App\SouvenirGroup','id','souvenir_group_id');
    }
    
    public function member() {
        return $this->hasOne('App\Member','id','member_id');
    }
}
