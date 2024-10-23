<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $paymentMethods;
    protected $breadcrumbs = [];
  
    public function index(Request $request)
    {
        $title = "Quản lý phương thức thanh toán";
   
        $this->breadcrumbs[] = [
            "active" => true,
            "url" => route("admin.payment_methods"),
            "name" => "Quản lý phương thức thanh toán"
        ];
        $breadcrumbs = $this->breadcrumbs;
        $keywords = $request->input('keywords');
        $orders = Order::with(['user', 'orderItems', 'promotion', 'paymentMethod'])->get();
        
        return view("backend.orders.templates.index", compact("title", "breadcrumbs",'orders'));
    }
    public function update(Request $request){
        // Tìm đơn hàng theo ID
    $order = Order::find($request->order_id);

    if ($order) {
        if ($request->status === 7) { 
            if ($order->payment_status === 2) {
                $order->payment_status = 3;
            }
        }
        if($request->status == 6){
            if($order->payment_status ==1){
                $order->payment_status = 2;
            }
        }
        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true, 'newStatus' => $order->status,"newPaymebnt_status" => $order->payment_status]);
    }

    return response()->json(['success' => false]);
    }
}
