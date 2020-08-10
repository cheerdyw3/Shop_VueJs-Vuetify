<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
    protected $table = "Orders";
    protected $fillable = [
        "user_id",'price','shipping','total','status','discount','ems','created_at','updated_at'
    ];

    // public function ordersDetail() {
    //     return $this->hasMany('App\OrdersDetail','order_id','id')->with('member')->with('souvenir_group')->with('Unit');
    // }
    public function shopsOrders() {
        return $this->hasMany('App\ShopsOrders','order_id','id')->with('member')->with('ordersDetail');
    }
    

    public function ordersDetail() {
        return $this->hasMany('App\OrdersDetail','order_id','order_id')->with('souvenir_group')->with('Unit');
    }
}
