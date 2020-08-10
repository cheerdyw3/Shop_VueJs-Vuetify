<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Souvenir extends Model
{
    protected $table = "souvenir";
    protected $fillable = [  
        'name', 'description', 'price', 'weight', 'unit_id',  'souvenir_group_id', 'member_id', 'image'
    ];

    // public function delivery() {
    //     return $this->hasMany('App\MemberDelivery')->with('weight')->with('detail');

    // }
    
}
