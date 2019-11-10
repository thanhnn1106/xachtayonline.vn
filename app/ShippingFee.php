<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipping_fee';
    protected $fillable = ['name'];
}
