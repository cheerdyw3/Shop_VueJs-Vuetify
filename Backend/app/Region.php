<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    protected $table = "region";
    protected $fillable = [
        'name', 'sort','image'
    ];

    public function member() {
        return $this->hasMany('App\Member');
    }

}
