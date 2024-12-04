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
    const PAYMENT_STATUS_PAID = 2;
    use HasFactory,SoftDeletes;
     // Các trạng thái đơn hàng
     const STATUS_PENDING = 1;
     const STATUS_CONFIRM = 2;
     const STATUS_PROCESSING = 3;
     const STATUS_SHIPPED = 4;
     const STATUS_SHIPPEDS = 5;
     const STATUS_COMPLETED = 6;
     const STATUS_CANCELLED = 7;
     const STATUS_REFUNDED = 8;
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
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'user_id', 'customer_id');
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
    public function getStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'Chờ xử lý',
            self::STATUS_CONFIRM => 'Đã xác nhận',
            self::STATUS_PROCESSING => 'Đang xử lý',
            self::STATUS_SHIPPED => 'Đang giao hàng',
            self::STATUS_SHIPPEDS => 'Đã giao hàng',
            self::STATUS_COMPLETED => 'Hoàn thành',
            self::STATUS_CANCELLED => 'Đã hủy',
            self::STATUS_REFUNDED => 'Đã hoàn tiền',
        ];

        return $statuses[$this->status] ?? 'Không xác định';
    }

    // Chuyển đổi trạng thái thanh toán sang tiếng Việt
    public function getPaymentStatusTextAttribute()
    {
        $paymentStatuses = [
            self::PAYMENT_PENDING => 'Chưa thanh toán',
            self::PAYMENT_COMPLETED => 'Đã thanh toán',
            self::PAYMENT_FAILED => 'Thanh toán thất bại',
            self::PAYMENT_REFUNDED => 'Đã hoàn tiền',
        ];

        return $paymentStatuses[$this->payment_status] ?? 'Không xác định';
    }
}
