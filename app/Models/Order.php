<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    const PAYMENT_PENDING = 1;
    const PAYMENT_COMPLETED = 2;
    const PAYMENT_FAILED = 3;
    const PAYMENT_REFUNDED = 4;
    use HasFactory,SoftDeletes;
     // Các trạng thái đơn hàng
     const STATUS_PENDING = 1;
     const STATUS_CONFIRM = 2;
     const STATUS_PROCESSING = 3;
     const STATUS_SHIPPED = 4;
     const STATUS_COMPLETED = 5;
     const STATUS_CANCELLED = 6;
     const STATUS_REFUNDED = 7;
    protected $fillable = [
        'customer_id',
        'customer_name',
        'promotion_id',
        'total_amount',
        'discount_amount',
        'final_amount',
        'status',
        'payment_status',
        'shipping_address',
        'shipping_fee',
        'payment_method_id',
        'discount_code',
        'email',
        'phone_number',
        'note',
        'created_at',
        'updated_at',
    ];
    protected $table = "orders";
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethods::class);
    }
    public function calculateFinalAmount()
    {
        $this->final_amount = $this->total_amount - $this->discount_amount;
        $this->save();
    }
    public function customer(){
        return $this->belongsTo(User::class,"customer_id");
    }
}
