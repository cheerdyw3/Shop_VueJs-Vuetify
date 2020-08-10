<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SouvenirGroup extends Model
{
    protected $table = "souvenir_group";
    protected $fillable = [
        'name', 'sort' 
    ];
}
