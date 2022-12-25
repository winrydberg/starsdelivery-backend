<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function dropoffs(){
        return $this->hasMany(DropOff::class);
    }
}