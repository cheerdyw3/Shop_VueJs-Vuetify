<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusOrders extends Model
{
    //
    protected $table = "status_orders";
    protected $fillable = [
        'name', 
    ];
}
