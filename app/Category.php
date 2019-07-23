<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    
    public function sub_categories(){
        if (strpos(url()->current(), 'dashboard')) {
            return $this->hasMany('App\Sub_Category')->orderBy('ordering');
        }
        return $this->hasMany('App\Sub_Category')->where('is_active', '1')->orderBy('ordering');
    }

    public function brands(){
        return $this->hasMany(Brand::class);
    }
}
