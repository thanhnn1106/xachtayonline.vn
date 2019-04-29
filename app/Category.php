<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    
    public function sub_categories(){
        if (strpos(url()->current(), 'dashboard')) {
            return $this->hasMany('App\Sub_Category');
        }
        return $this->hasMany('App\Sub_Category')->whereIsActive(1);
    }

    public function brands(){
        return $this->hasMany(Brand::class);
    }
}
