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
    public function createPttt($data){
        DB::table('payment_methods')->insert($data);
    }
    public function getDetailPaymentMethods($id){
        $paymentMethods=DB::table('payment_methods')->where('id',$id)->first();
    return $paymentMethods;
    }
    public function updatePaymentMethods($id,$params){
        DB::table('payment_methods')->where('id',$id)->update($params);
    }
}
