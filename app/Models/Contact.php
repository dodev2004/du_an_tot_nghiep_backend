<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contact extends Model
{
    use HasFactory,SoftDeletes, Prunable;

    protected function prunable()
    {
        // Xác định các bản ghi có updated_at cũ hơn 30 ngày
        return static::where('updated_at', '<', now()->subDays(1));
    }

    protected $fillable = [
        "image",
        "content",
        "user_id",
        "response",
        "status",
        "customer_delete"
    ];
    protected $table = "contacts";
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
