<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    //
    protected $table = "weight";
    protected $fillable = [
        'delivery_id', 'grams', 'price'
    ];

    
}
