<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'code', 
        'discount_value',
        'discount_type', 
        'status', 
        'start_date',
        'end_date', 
        'max_uses',
        'quantity',
        'used_count',
        "gt_don_hang_toi_thieu",
        "gia_tri_giam_toi_da"
    ];
    protected $table = "promotions";
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
