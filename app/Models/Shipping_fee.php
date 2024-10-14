<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Shipping_fee extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        "province_code",
        "fee",
        "weight_limit",
        "status",
    ];
    protected $table = "shipping_fees";
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code','code');
    }
}
