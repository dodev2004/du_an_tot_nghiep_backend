<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $primaryKey = "code";
    protected $keyType = 'string';
    public function districts(){
        return $this->hasMany(District::class,"province_code","code");
    }
    public function shippingFees()
    {
        return $this->hasMany(Shipping_fee::class, 'province_code', 'code');
    }
}
