<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $table = 'orders';

    CONST order_status_processed = 1;
    CONST order_status_accepted = 2;
    CONST order_status_pending = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id', 'order_status', 'address', 'street', 'city', 'postcode', 'order_quantity'
    ];

}
