<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ad(){
        return $this->belongsTo(Ad::class);
    }
}
