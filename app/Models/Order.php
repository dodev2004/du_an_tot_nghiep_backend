<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        "user_id",
        "customer_name",
        "promotion_id",
        "total_amount",
        "discount_amount",
        "final_amount",
        "status",
        "payment_status",
        "shipping_address",
        "shipping_method",
        "shipping_fee",
        "payment_method_id",
        "discount_code",
        "order_status",
        "email",
        "phone_number",
        "note",
    ];
    protected $table = "orders";
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
