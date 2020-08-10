<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopsOrders extends Model
{
    //
    protected $table = "ShopsOrders";
    protected $fillable = [
        'shop_id','order_id','ordersDetail_id','discount','price','shipping','total','delivery_code','orderStatus','deliveryNameAddress','deliveryAddress','created_at','updated_at','deliveryId','deliveryName','deliveryPrice'
    ];

    public function member() {
        return $this->hasOne('App\Member','id','shop_id');
    }
    
    public function ordersDetail() {
        return $this->hasMany('App\OrdersDetail','member_id','shop_id')->with('souvenir_group')->with('Unit');
    }
}

