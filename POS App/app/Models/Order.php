<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = [
        "invoice",
        "customer_id",
        "user_id",
        "total",
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

}
