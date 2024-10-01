<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethods extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "description",
    ];
    public function getList(){
        $paymentMethods = DB::tabel('payment_methods')->get();
        return $paymentMethods;
    }
}
