<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropOff extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function delivery(){
        return $this->belongsTo(Delivery::class);
    }
}