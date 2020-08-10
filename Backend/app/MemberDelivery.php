<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberDelivery extends Model
{
    //
    protected $table = "member_delivery";
    protected $fillable = [  
        'member_id', 'delivery_id',
    ];
    public function weight() {
        return $this->hasMany('App\Weight','delivery_id','delivery_id');
    }
    public function detail() {
        return $this->hasOne('App\Delivery','id','delivery_id');
    }
}
